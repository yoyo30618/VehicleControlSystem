using MQTTnet;
using MQTTnet.Client;
using MySql.Data.MySqlClient;
using System.Data;
using System.Text;
using System;
using System.IO;
using Mysqlx.Crud;
using System.Security.Cryptography;
using System.Windows.Forms;

namespace VehicleControlSystem
{
    public partial class Form1 : Form
    {
        private IMqttClient mqttClient;
        private MqttClientOptions mqttOptions;
        private MySqlConnection mysqlConnection;
        private List<string> subscribedTopics = new List<string>();
        private bool isDbConnected = false;
        private bool shouldReconnectMqtt = false;
        private bool shouldReconnectDb = false;
        private string Log_DirPath = "C#_Log";
        private Dictionary<string,LastRecord> LastRecordHis= new Dictionary<string, LastRecord>();
        private int TopicTimesGap = 1;
        public class LastRecord
        {
            public DateTime V_LastTime;
            public DateTime Loc_LastTime;
        }
        public Form1()
        {
            InitializeComponent();
            InitializeReconnectTimer();
        }

        private void InitializeReconnectTimer()
        {
            reconnectTimer.Tick += async (sender, e) => await HandleReconnection();//每五秒進行一次
            reconnectTimer.Start();
        }
        private async Task HandleReconnection()
        {
            if (shouldReconnectDb && !isDbConnected)// 如果需要連線DB 且 DB未連線
            {
                await ConnectToDatabase();
            }

            if (shouldReconnectMqtt && (mqttClient == null || !mqttClient.IsConnected) && isDbConnected)//如果需要重連MQTT 且 MQTT未連線 且 DB已連線
            {
                await ConnectToMqttBroker();
            }
        }
        private async void Btn_ConnectDB_Click(object sender, EventArgs e)
        {
            shouldReconnectDb = true;//等待連線DB
            await ConnectToDatabase();
        }
        private async Task ConnectToDatabase()
        {
            LogMessage("嘗試對DB連線...");
            try
            {
                if (mysqlConnection != null && mysqlConnection.State == ConnectionState.Open)
                {
                    mysqlConnection.Close();
                }
                string DB_Connect_String = $"Server={Txt_DB_Host.Text};Database={Txt_DB_DBName.Text};Uid={Txt_DB_Account.Text};Pwd={Txt_DB_Pwd.Text};";
                mysqlConnection = new MySqlConnection(DB_Connect_String);
                await mysqlConnection.OpenAsync();
                isDbConnected = true;
                LogMessage("DB連線成功！");
                Lbl_DB_NowStatus.Text = "DB連線成功！";
                Lbl_DB_NowStatus.BackColor = Color.Green;
                Btn_ConnectMQTT.Enabled = true;//連線成功
                await LoadTopicsFromDatabase();// 讀取訂閱主題
            }
            catch (Exception ex)
            {
                isDbConnected = false;
                Lbl_DB_NowStatus.Text = "DB尚未連線！";
                Lbl_DB_NowStatus.BackColor = Color.Red;
                LogMessage($"DB尚未連線！: {ex.Message}");
            }
        }
        private async Task LoadTopicsFromDatabase()
        {
            try
            {
                subscribedTopics.Clear();
                int cnt = 0;
                using (var cmd = new MySqlCommand("SELECT * FROM `carinfo` WHERE `IsUsed`=1", mysqlConnection))
                using (var reader = await cmd.ExecuteReaderAsync())
                {
                    Lst_CarInfo.Items.Clear();
                    Lst_CarInfo.Items.Add("車輛ID\t車輛名稱\tTopic");
                    while (await reader.ReadAsync())
                    {
                        string CarID = reader.GetString(1);
                        string v = reader.GetString(2);
                        string loc = reader.GetString(3);
                        string CarName = reader.GetString(5);
                        if (v != string.Empty)
                        {
                            Lst_CarInfo.Items.Add($"{CarID}\t{CarName}\t{v}");
                            subscribedTopics.Add(v);//電壓資訊
                            cnt++;
                        }
                        if (loc != string.Empty)
                        {
                            Lst_CarInfo.Items.Add($"{CarID}\t{CarName}\t{loc}");
                            subscribedTopics.Add(loc);//座標資訊
                            cnt++;
                        }
                    }
                }
                LogMessage($"DB內共有{cnt}組Topic");
            }
            catch (Exception ex)
            {
                LogMessage($"DB內資訊錯誤: {ex.Message}");
            }
        }

        private async void Btn_ConnectMQTT_Click(object sender, EventArgs e)
        {

            shouldReconnectMqtt = true;
            await ConnectToMqttBroker();
        }
        private async Task ConnectToMqttBroker()
        {
            LogMessage("嘗試對MQTT連線...");
            try
            {
                if (mqttClient != null && mqttClient.IsConnected)
                {
                    await mqttClient.DisconnectAsync();
                }

                var factory = new MqttFactory();
                mqttClient = factory.CreateMqttClient();

                mqttClient.ApplicationMessageReceivedAsync += async e =>
                {
                    var payload = Encoding.UTF8.GetString(e.ApplicationMessage.PayloadSegment);
                    await SaveMessageToDatabase(e.ApplicationMessage.Topic, payload);
                };

                mqttClient.DisconnectedAsync += e =>
                {
                    this.Invoke((MethodInvoker)delegate
                    {
                        LogMessage("MQTT連接斷開");
                        UpdateConnectionStatus(false);
                    });
                    return Task.CompletedTask;
                };

                mqttOptions = new MqttClientOptionsBuilder()
                    .WithTcpServer(Txt_MQTT_Host.Text, int.Parse(Txt_MQTT_Port.Text))
                    .WithClientId($"WinForm_{Guid.NewGuid()}")
                    .WithCredentials(Txt_MQTT_Account.Text, Txt_MQTT_Pwd.Text)
                    .WithCleanSession()
                    .Build();
                await mqttClient.ConnectAsync(mqttOptions);
                Lbl_MQTT_NowStatus.Text = "MQTT連線成功！";
                Lbl_MQTT_NowStatus.BackColor = Color.Green;
                LastRecordHis = new Dictionary<string, LastRecord>();
                foreach (var topic in subscribedTopics) // 訂閱所有主題
                {
                    await mqttClient.SubscribeAsync(topic);
                    LogMessage($"已訂閱: {topic}");
                }
                UpdateConnectionStatus(true);
            }
            catch (Exception ex)
            {
                Lbl_MQTT_NowStatus.Text = "MQTT尚未連線！";
                Lbl_MQTT_NowStatus.BackColor = Color.Red;
                LogMessage($"MQTT連接錯誤: {ex.Message}");
            }
        }
        private async Task SaveMessageToDatabase(string topic, string payload)
        {
            if (!isDbConnected) return;

            try
            {
                string Mode = "v";
                bool InsertData = true;
                string CarID = topic.Replace("loc", "").Replace("v", "").Replace("/", "");
                if (topic.Contains("loc")) Mode = "loc";
                if (!LastRecordHis.ContainsKey(CarID))
                {
                    LastRecordHis.Add(CarID, new LastRecord());
                }
                if (Mode == "v")
                {
                    TimeSpan timeDifference = DateTime.Now.Subtract(LastRecordHis[CarID].V_LastTime);
                    double minutesDifference = timeDifference.TotalMinutes;
                    if (minutesDifference< TopicTimesGap)//未滿一分鐘，不紀錄
                        InsertData=false;
                    else
                        LastRecordHis[CarID].V_LastTime = DateTime.Now;
                }
                else if (Mode == "loc")
                {
                    TimeSpan timeDifference = DateTime.Now.Subtract(LastRecordHis[CarID].Loc_LastTime);
                    double minutesDifference = timeDifference.TotalMinutes;
                    if (minutesDifference < TopicTimesGap)//未滿一分鐘，不紀錄
                        InsertData = false;
                    else
                        LastRecordHis[CarID].Loc_LastTime = DateTime.Now;
                }
                if (InsertData)
                {
                    using (var cmd = new MySqlCommand(
                        "INSERT INTO `carrecord`(`DateTime`, `CarID`, `Record`, `TopicMode`) VALUES(@DateTime, @CarID, @Record, @TopicMode)",
                        mysqlConnection))
                    {
                        cmd.Parameters.AddWithValue("@DateTime", DateTime.Now);
                        cmd.Parameters.AddWithValue("@CarID", CarID);
                        cmd.Parameters.AddWithValue("@Record", payload);
                        cmd.Parameters.AddWithValue("@TopicMode", Mode);
                        await cmd.ExecuteNonQueryAsync();
                    }
                    LogMessage($"寫入DB: {CarID},{Mode},{payload}");
                }
            }
            catch (Exception ex)
            {
                LogMessage($"保存消息到DB錯誤: {ex.Message}");
                if (!mysqlConnection.Ping())
                {
                    isDbConnected = false;
                    shouldReconnectDb = true;
                }
            }
        }
        private void UpdateConnectionStatus(bool isConnected)
        {
            Btn_ConnectMQTT.Enabled = isDbConnected && !isConnected;
            Btn_ConnectDB.Enabled = !isDbConnected;
        }
        private void LogMessage(string message)
        {
            this.Invoke((MethodInvoker)delegate
            {
                // 準備日誌內容
                string logMessage = $"[{DateTime.Now:yyyy-MM-dd HH:mm:ss}] {message}";
                DateTime currentFileHour = DateTime.Now;
                string fileName = $"Log_{currentFileHour:yyyy-MM-dd_HH}00.txt";
                string Log_FilePath = Path.Combine(Log_DirPath, fileName);
                if (!Directory.Exists(Log_DirPath)) // 確認目錄是否存在，若不存在則建立
                {
                    Directory.CreateDirectory(Log_DirPath);
                }
                if (!File.Exists(Log_FilePath))
                    File.Create(Log_FilePath).Close(); // 建立檔案並關閉
                try
                {
                    File.AppendAllText(Log_FilePath, logMessage + Environment.NewLine);
                }
                catch (Exception ex)
                {
                    string backupFile = Path.Combine(Log_DirPath, $"Backup_{DateTime.Now:yyyy-MM-dd_HHmmss}.txt");
                    File.AppendAllText(backupFile, logMessage + Environment.NewLine);
                }
                if (Lst_MQTT_His.Items.Count > 100)
                    Lst_MQTT_His.Items.RemoveAt(0);
                Lst_MQTT_His.Items.Add(logMessage);
                Lst_MQTT_His.TopIndex = Lst_MQTT_His.Items.Count - 1;
            });
        }
    }
}
