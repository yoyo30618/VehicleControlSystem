namespace VehicleControlSystem
{
    partial class Form1
    {
        /// <summary>
        ///  Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        ///  Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        ///  Required method for Designer support - do not modify
        ///  the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            components = new System.ComponentModel.Container();
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Form1));
            Lbl_CarInfo = new Label();
            Lst_CarInfo = new ListBox();
            Txt_DB_Host = new TextBox();
            Txt_DB_DBName = new TextBox();
            Txt_DB_Account = new TextBox();
            Txt_DB_Pwd = new TextBox();
            Txt_MQTT_Pwd = new TextBox();
            Txt_MQTT_Account = new TextBox();
            Txt_MQTT_Port = new TextBox();
            Txt_MQTT_Host = new TextBox();
            Lbl_DB = new Label();
            Lbl_MQTT = new Label();
            Lbl_MQTT_Port = new Label();
            Lbl_MQTT_Host = new Label();
            Lbl_DB_Host = new Label();
            Lbl_DB_Account = new Label();
            Lbl_DB_Pwd = new Label();
            Lbl_DB_DBName = new Label();
            Btn_ConnectDB = new Button();
            Lbl_MQTT_Account = new Label();
            Lbl_MQTT_Pwd = new Label();
            Btn_ConnectMQTT = new Button();
            Lst_MQTT_His = new ListBox();
            Lbl_MQTT_His = new Label();
            Lbl_DB_NowStatus = new Label();
            Lbl_MQTT_NowStatus = new Label();
            reconnectTimer = new System.Windows.Forms.Timer(components);
            SuspendLayout();
            // 
            // Lbl_CarInfo
            // 
            Lbl_CarInfo.AutoSize = true;
            Lbl_CarInfo.Font = new Font("微軟正黑體", 9F);
            Lbl_CarInfo.Location = new Point(12, 9);
            Lbl_CarInfo.Name = "Lbl_CarInfo";
            Lbl_CarInfo.Size = new Size(127, 32);
            Lbl_CarInfo.TabIndex = 0;
            Lbl_CarInfo.Text = "目前已登入的車輛訊息\r\n(請至網頁更新內容)";
            // 
            // Lst_CarInfo
            // 
            Lst_CarInfo.Font = new Font("微軟正黑體", 9F);
            Lst_CarInfo.FormattingEnabled = true;
            Lst_CarInfo.Location = new Point(12, 42);
            Lst_CarInfo.Name = "Lst_CarInfo";
            Lst_CarInfo.Size = new Size(377, 132);
            Lst_CarInfo.TabIndex = 1;
            // 
            // Txt_DB_Host
            // 
            Txt_DB_Host.Font = new Font("微軟正黑體", 9F);
            Txt_DB_Host.Location = new Point(61, 258);
            Txt_DB_Host.Name = "Txt_DB_Host";
            Txt_DB_Host.Size = new Size(135, 23);
            Txt_DB_Host.TabIndex = 2;
            Txt_DB_Host.Text = "127.0.0.1";
            // 
            // Txt_DB_DBName
            // 
            Txt_DB_DBName.Font = new Font("微軟正黑體", 9F);
            Txt_DB_DBName.Location = new Point(61, 292);
            Txt_DB_DBName.Name = "Txt_DB_DBName";
            Txt_DB_DBName.Size = new Size(135, 23);
            Txt_DB_DBName.TabIndex = 3;
            Txt_DB_DBName.Text = "vehiclecontrolsystem";
            // 
            // Txt_DB_Account
            // 
            Txt_DB_Account.Font = new Font("微軟正黑體", 9F);
            Txt_DB_Account.Location = new Point(61, 330);
            Txt_DB_Account.Name = "Txt_DB_Account";
            Txt_DB_Account.Size = new Size(135, 23);
            Txt_DB_Account.TabIndex = 4;
            Txt_DB_Account.Text = "vehiclecontrolsystem";
            // 
            // Txt_DB_Pwd
            // 
            Txt_DB_Pwd.Font = new Font("微軟正黑體", 9F);
            Txt_DB_Pwd.Location = new Point(61, 370);
            Txt_DB_Pwd.Name = "Txt_DB_Pwd";
            Txt_DB_Pwd.PasswordChar = '●';
            Txt_DB_Pwd.Size = new Size(135, 23);
            Txt_DB_Pwd.TabIndex = 5;
            Txt_DB_Pwd.Text = "vehiclecontrolsystem";
            // 
            // Txt_MQTT_Pwd
            // 
            Txt_MQTT_Pwd.Font = new Font("微軟正黑體", 9F);
            Txt_MQTT_Pwd.Location = new Point(254, 370);
            Txt_MQTT_Pwd.Name = "Txt_MQTT_Pwd";
            Txt_MQTT_Pwd.PasswordChar = '●';
            Txt_MQTT_Pwd.Size = new Size(135, 23);
            Txt_MQTT_Pwd.TabIndex = 9;
            Txt_MQTT_Pwd.Text = "5893456258";
            // 
            // Txt_MQTT_Account
            // 
            Txt_MQTT_Account.Font = new Font("微軟正黑體", 9F);
            Txt_MQTT_Account.Location = new Point(254, 330);
            Txt_MQTT_Account.Name = "Txt_MQTT_Account";
            Txt_MQTT_Account.Size = new Size(135, 23);
            Txt_MQTT_Account.TabIndex = 8;
            Txt_MQTT_Account.Text = "yotta";
            // 
            // Txt_MQTT_Port
            // 
            Txt_MQTT_Port.Font = new Font("微軟正黑體", 9F);
            Txt_MQTT_Port.Location = new Point(254, 287);
            Txt_MQTT_Port.Name = "Txt_MQTT_Port";
            Txt_MQTT_Port.Size = new Size(135, 23);
            Txt_MQTT_Port.TabIndex = 7;
            Txt_MQTT_Port.Text = "1883";
            // 
            // Txt_MQTT_Host
            // 
            Txt_MQTT_Host.Font = new Font("微軟正黑體", 9F);
            Txt_MQTT_Host.Location = new Point(254, 253);
            Txt_MQTT_Host.Name = "Txt_MQTT_Host";
            Txt_MQTT_Host.Size = new Size(135, 23);
            Txt_MQTT_Host.TabIndex = 6;
            Txt_MQTT_Host.Text = "yotta.synology.me";
            // 
            // Lbl_DB
            // 
            Lbl_DB.AutoSize = true;
            Lbl_DB.Font = new Font("微軟正黑體", 9F);
            Lbl_DB.Location = new Point(61, 226);
            Lbl_DB.Name = "Lbl_DB";
            Lbl_DB.Size = new Size(71, 16);
            Lbl_DB.TabIndex = 10;
            Lbl_DB.Text = "DB連線資訊";
            // 
            // Lbl_MQTT
            // 
            Lbl_MQTT.AutoSize = true;
            Lbl_MQTT.Font = new Font("微軟正黑體", 9F);
            Lbl_MQTT.Location = new Point(249, 226);
            Lbl_MQTT.Name = "Lbl_MQTT";
            Lbl_MQTT.Size = new Size(91, 16);
            Lbl_MQTT.TabIndex = 11;
            Lbl_MQTT.Text = "MQTT連線資訊";
            // 
            // Lbl_MQTT_Port
            // 
            Lbl_MQTT_Port.AutoSize = true;
            Lbl_MQTT_Port.Font = new Font("微軟正黑體", 9F);
            Lbl_MQTT_Port.Location = new Point(217, 295);
            Lbl_MQTT_Port.Name = "Lbl_MQTT_Port";
            Lbl_MQTT_Port.Size = new Size(31, 16);
            Lbl_MQTT_Port.TabIndex = 12;
            Lbl_MQTT_Port.Text = "埠號";
            // 
            // Lbl_MQTT_Host
            // 
            Lbl_MQTT_Host.AutoSize = true;
            Lbl_MQTT_Host.Font = new Font("微軟正黑體", 9F);
            Lbl_MQTT_Host.Location = new Point(217, 261);
            Lbl_MQTT_Host.Name = "Lbl_MQTT_Host";
            Lbl_MQTT_Host.Size = new Size(31, 16);
            Lbl_MQTT_Host.TabIndex = 13;
            Lbl_MQTT_Host.Text = "主機";
            // 
            // Lbl_DB_Host
            // 
            Lbl_DB_Host.AutoSize = true;
            Lbl_DB_Host.Font = new Font("微軟正黑體", 9F);
            Lbl_DB_Host.Location = new Point(24, 266);
            Lbl_DB_Host.Name = "Lbl_DB_Host";
            Lbl_DB_Host.Size = new Size(31, 16);
            Lbl_DB_Host.TabIndex = 14;
            Lbl_DB_Host.Text = "主機";
            // 
            // Lbl_DB_Account
            // 
            Lbl_DB_Account.AutoSize = true;
            Lbl_DB_Account.Font = new Font("微軟正黑體", 9F);
            Lbl_DB_Account.Location = new Point(24, 338);
            Lbl_DB_Account.Name = "Lbl_DB_Account";
            Lbl_DB_Account.Size = new Size(31, 16);
            Lbl_DB_Account.TabIndex = 15;
            Lbl_DB_Account.Text = "帳號";
            // 
            // Lbl_DB_Pwd
            // 
            Lbl_DB_Pwd.AutoSize = true;
            Lbl_DB_Pwd.Font = new Font("微軟正黑體", 9F);
            Lbl_DB_Pwd.Location = new Point(24, 378);
            Lbl_DB_Pwd.Name = "Lbl_DB_Pwd";
            Lbl_DB_Pwd.Size = new Size(31, 16);
            Lbl_DB_Pwd.TabIndex = 16;
            Lbl_DB_Pwd.Text = "密碼";
            // 
            // Lbl_DB_DBName
            // 
            Lbl_DB_DBName.AutoSize = true;
            Lbl_DB_DBName.Font = new Font("微軟正黑體", 9F);
            Lbl_DB_DBName.Location = new Point(12, 300);
            Lbl_DB_DBName.Name = "Lbl_DB_DBName";
            Lbl_DB_DBName.Size = new Size(43, 16);
            Lbl_DB_DBName.TabIndex = 17;
            Lbl_DB_DBName.Text = "資料庫";
            // 
            // Btn_ConnectDB
            // 
            Btn_ConnectDB.Font = new Font("微軟正黑體", 14F);
            Btn_ConnectDB.Location = new Point(24, 405);
            Btn_ConnectDB.Name = "Btn_ConnectDB";
            Btn_ConnectDB.Size = new Size(172, 42);
            Btn_ConnectDB.TabIndex = 18;
            Btn_ConnectDB.Text = "嘗試DB連線";
            Btn_ConnectDB.UseVisualStyleBackColor = true;
            Btn_ConnectDB.Click += Btn_ConnectDB_Click;
            // 
            // Lbl_MQTT_Account
            // 
            Lbl_MQTT_Account.AutoSize = true;
            Lbl_MQTT_Account.Font = new Font("微軟正黑體", 9F);
            Lbl_MQTT_Account.Location = new Point(217, 338);
            Lbl_MQTT_Account.Name = "Lbl_MQTT_Account";
            Lbl_MQTT_Account.Size = new Size(31, 16);
            Lbl_MQTT_Account.TabIndex = 19;
            Lbl_MQTT_Account.Text = "帳號";
            // 
            // Lbl_MQTT_Pwd
            // 
            Lbl_MQTT_Pwd.AutoSize = true;
            Lbl_MQTT_Pwd.Font = new Font("微軟正黑體", 9F);
            Lbl_MQTT_Pwd.Location = new Point(217, 378);
            Lbl_MQTT_Pwd.Name = "Lbl_MQTT_Pwd";
            Lbl_MQTT_Pwd.Size = new Size(31, 16);
            Lbl_MQTT_Pwd.TabIndex = 20;
            Lbl_MQTT_Pwd.Text = "密碼";
            // 
            // Btn_ConnectMQTT
            // 
            Btn_ConnectMQTT.Enabled = false;
            Btn_ConnectMQTT.Font = new Font("微軟正黑體", 14F);
            Btn_ConnectMQTT.Location = new Point(217, 405);
            Btn_ConnectMQTT.Name = "Btn_ConnectMQTT";
            Btn_ConnectMQTT.Size = new Size(172, 42);
            Btn_ConnectMQTT.TabIndex = 21;
            Btn_ConnectMQTT.Text = "嘗試MQTT連線";
            Btn_ConnectMQTT.UseVisualStyleBackColor = true;
            Btn_ConnectMQTT.Click += Btn_ConnectMQTT_Click;
            // 
            // Lst_MQTT_His
            // 
            Lst_MQTT_His.Font = new Font("微軟正黑體", 9F);
            Lst_MQTT_His.FormattingEnabled = true;
            Lst_MQTT_His.Location = new Point(398, 42);
            Lst_MQTT_His.Name = "Lst_MQTT_His";
            Lst_MQTT_His.Size = new Size(627, 388);
            Lst_MQTT_His.TabIndex = 22;
            // 
            // Lbl_MQTT_His
            // 
            Lbl_MQTT_His.AutoSize = true;
            Lbl_MQTT_His.Font = new Font("微軟正黑體", 9F);
            Lbl_MQTT_His.Location = new Point(398, 9);
            Lbl_MQTT_His.Name = "Lbl_MQTT_His";
            Lbl_MQTT_His.Size = new Size(115, 16);
            Lbl_MQTT_His.TabIndex = 23;
            Lbl_MQTT_His.Text = "MQTT歷史接收紀錄";
            // 
            // Lbl_DB_NowStatus
            // 
            Lbl_DB_NowStatus.AutoSize = true;
            Lbl_DB_NowStatus.BackColor = Color.Red;
            Lbl_DB_NowStatus.Font = new Font("微軟正黑體", 18F);
            Lbl_DB_NowStatus.Location = new Point(12, 186);
            Lbl_DB_NowStatus.Name = "Lbl_DB_NowStatus";
            Lbl_DB_NowStatus.Size = new Size(166, 30);
            Lbl_DB_NowStatus.TabIndex = 24;
            Lbl_DB_NowStatus.Text = "DB尚未連線！";
            // 
            // Lbl_MQTT_NowStatus
            // 
            Lbl_MQTT_NowStatus.AutoSize = true;
            Lbl_MQTT_NowStatus.BackColor = Color.Red;
            Lbl_MQTT_NowStatus.Font = new Font("微軟正黑體", 18F);
            Lbl_MQTT_NowStatus.Location = new Point(190, 186);
            Lbl_MQTT_NowStatus.Name = "Lbl_MQTT_NowStatus";
            Lbl_MQTT_NowStatus.Size = new Size(202, 30);
            Lbl_MQTT_NowStatus.TabIndex = 25;
            Lbl_MQTT_NowStatus.Text = "MQTT尚未連線！";
            // 
            // reconnectTimer
            // 
            reconnectTimer.Interval = 5000;
            // 
            // Form1
            // 
            AutoScaleDimensions = new SizeF(7F, 15F);
            AutoScaleMode = AutoScaleMode.Font;
            ClientSize = new Size(1050, 450);
            Controls.Add(Lbl_MQTT_NowStatus);
            Controls.Add(Lbl_DB_NowStatus);
            Controls.Add(Lbl_MQTT_His);
            Controls.Add(Lst_MQTT_His);
            Controls.Add(Btn_ConnectMQTT);
            Controls.Add(Lbl_MQTT_Pwd);
            Controls.Add(Lbl_MQTT_Account);
            Controls.Add(Btn_ConnectDB);
            Controls.Add(Lbl_DB_DBName);
            Controls.Add(Lbl_DB_Pwd);
            Controls.Add(Lbl_DB_Account);
            Controls.Add(Lbl_DB_Host);
            Controls.Add(Lbl_MQTT_Host);
            Controls.Add(Lbl_MQTT_Port);
            Controls.Add(Lbl_MQTT);
            Controls.Add(Lbl_DB);
            Controls.Add(Txt_MQTT_Pwd);
            Controls.Add(Txt_MQTT_Account);
            Controls.Add(Txt_MQTT_Port);
            Controls.Add(Txt_MQTT_Host);
            Controls.Add(Txt_DB_Pwd);
            Controls.Add(Txt_DB_Account);
            Controls.Add(Txt_DB_DBName);
            Controls.Add(Txt_DB_Host);
            Controls.Add(Lst_CarInfo);
            Controls.Add(Lbl_CarInfo);
            Icon = (Icon)resources.GetObject("$this.Icon");
            Name = "Form1";
            Text = "車輛狀態轉檔";
            ResumeLayout(false);
            PerformLayout();
        }

        #endregion

        private Label Lbl_CarInfo;
        private ListBox Lst_CarInfo;
        private TextBox Txt_DB_Host;
        private TextBox Txt_DB_DBName;
        private TextBox Txt_DB_Account;
        private TextBox Txt_DB_Pwd;
        private TextBox Txt_MQTT_Pwd;
        private TextBox Txt_MQTT_Account;
        private TextBox Txt_MQTT_Port;
        private TextBox Txt_MQTT_Host;
        private Label Lbl_DB;
        private Label Lbl_MQTT;
        private Label Lbl_MQTT_Port;
        private Label Lbl_MQTT_Host;
        private Label Lbl_DB_Host;
        private Label Lbl_DB_Account;
        private Label Lbl_DB_Pwd;
        private Label Lbl_DB_DBName;
        private Button Btn_ConnectDB;
        private Label Lbl_MQTT_Account;
        private Label Lbl_MQTT_Pwd;
        private Button Btn_ConnectMQTT;
        private ListBox Lst_MQTT_His;
        private Label Lbl_MQTT_His;
        private Label Lbl_DB_NowStatus;
        private Label Lbl_MQTT_NowStatus;
        private System.Windows.Forms.Timer reconnectTimer;
    }
}
