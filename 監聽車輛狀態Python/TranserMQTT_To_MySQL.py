import paho.mqtt.client as mqtt
import mysql.connector
from datetime import datetime, timedelta
import configparser
import time
import os
import logging
from logging.handlers import TimedRotatingFileHandler
import sys

config = configparser.ConfigParser()
config.read('TranserMQTT_To_MySQL_config.ini')
db_config = {
    'host': config['MySQL']['host'],
    'user': config['MySQL']['user'],
    'password': config['MySQL']['password'],
    'database': config['MySQL']['database']
}
mqtt_broker = config['MQTT']['broker']
mqtt_port = int(config['MQTT']['port'])
mqtt_username = config['MQTT']['username']
mqtt_password = config['MQTT']['password']

def on_connect(client, userdata, flags, rc, properties=None):
    print(f"連線成功 {rc}")
def SubscribeTopic(CarStatus):
    for CarItem in CarStatus:
        print(CarItem[2],CarItem[3])
        client.subscribe(CarItem[2])
        client.subscribe(CarItem[3])
def on_message(client, userdata, msg):
    try:
        current_time = time.time()
        timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        TopicMode = ""
        if "/loc" in msg.topic:
            TopicMode = "loc"
        elif "/v" in msg.topic:
            TopicMode = "v"
        else:
            return
        CarID = msg.topic.replace("/loc", "").replace("/v", "")
        delete_old_data(CarID)
        if CarID not in last_insert_time:# 初始化 CarID 的追踪記錄（如果不存在）
            last_insert_time[CarID] = {'loc': 0, 'v': 0}
        if CarID not in car_data_count:# 初始化 CarID 的追踪記錄（如果不存在）
            car_data_count[CarID] = {'loc': 0, 'v': 0}  # 初始化計數器
        if current_time - last_insert_time[CarID][TopicMode] >= 30:# 檢查是否已經過了30秒
            print(f"{timestamp} 我還活著")
            query = "INSERT INTO `carrecord` (`DateTime`, `CarID`, `Record`, `TopicMode`) VALUES (SYSDATE(), %s, %s, %s)"
            cursor.execute(query, (CarID, msg.payload.decode(), TopicMode))
            conn.commit()
            car_data_count[CarID][TopicMode] += 1  # 增加相應的計數器
            log_car_data_counts()
            last_insert_time[CarID][TopicMode] = current_time# 更新最後插入時間
    except Exception as e:
        print(f"Error: {e}")
        
def log_car_data_counts():
    logger.info("當前所有車輛資料統計：")
    for car_id, counts in car_data_count.items():
        logger.info(f"{car_id}: v {counts['v']} 筆; loc {counts['loc']} 筆")

def print_all_car_data_counts():
    timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
    print(f"\n{timestamp} 當前所有車輛資料統計：")
    for car_id, counts in car_data_count.items():
        print(f"{car_id}: v {counts['v']} 筆; loc {counts['loc']} 筆")
    print()  # 增加一個空行，使輸出更清晰

def setup_logger():
    log_dir = "logs"
    if not os.path.exists(log_dir):
        os.makedirs(log_dir)
    
    log_file = os.path.join(log_dir, "mqtt_mysql.log")
    logger = logging.getLogger("MQTTToMySQL")
    logger.setLevel(logging.INFO)
    
    handler = TimedRotatingFileHandler(log_file, when="H", interval=1, backupCount=24*7)
    formatter = logging.Formatter('%(asctime)s - %(levelname)s - %(message)s')
    handler.setFormatter(formatter)
    logger.addHandler(handler)
    
    return logger
def delete_old_data(CarID):
    try:
        timestamp = datetime.now().strftime('%Y-%m-%d %H:%M:%S')
        thirty_days_ago = datetime.now() - timedelta(days=7)
        query = "DELETE FROM `carrecord` WHERE `DateTime` < %s AND `CarID` = %s"
        cursor.execute(query, (thirty_days_ago,CarID))
        conn.commit()
        if(cursor.rowcount>0):
            logger.info(f"{timestamp} 已刪除 {CarID}，共{cursor.rowcount} 筆7天前的舊數據")
    except Exception as e:
        print(f"刪除舊數據時發生錯誤: {e}")
def connect_mqtt():
    client = mqtt.Client(mqtt.CallbackAPIVersion.VERSION2)
    client.on_connect = on_connect
    client.on_message = on_message
    client.username_pw_set(mqtt_username, mqtt_password)
    
    retry_count = 0
    while retry_count < 5:
        try:
            client.connect(mqtt_broker, mqtt_port, 60)
            logger.info("成功連接到 MQTT broker")
            return client
        except Exception as e:
            retry_count += 1
            logger.error(f"連接 MQTT broker 失敗，重試 {retry_count}/5: {e}")
            time.sleep(10)
    
    logger.critical("無法連接到 MQTT broker，程序退出")
    sys.exit(1)

def connect_mysql():
    retry_count = 0
    while retry_count < 5:
        try:
            conn = mysql.connector.connect(**db_config)
            logger.info("成功連接到 MySQL 數據庫")
            return conn
        except Exception as e:
            retry_count += 1
            logger.error(f"連接 MySQL 失敗，重試 {retry_count}/5: {e}")
            time.sleep(10)
    
    logger.critical("無法連接到 MySQL 數據庫，程序退出")
    sys.exit(1)
def main():
    global conn, cursor, client
    
    while True:
        try:
            conn = connect_mysql()
            cursor = conn.cursor()
            
            query = "SELECT * FROM `carinfo` WHERE 1 AND `IsUsed`=1"
            cursor.execute(query)
            CarStatus = cursor.fetchall()
            
            client = connect_mqtt()
            SubscribeTopic(CarStatus)
            
            logger.info("開始 MQTT 循環")
            client.loop_forever()
        
        except KeyboardInterrupt:
            logger.info("程序被用戶中斷")
            break
        except Exception as e:
            logger.error(f"發生異常: {e}")
            logger.info("5秒後重新啟動程序")
            time.sleep(5)
        finally:
            if 'client' in locals() and client is not None:
                client.disconnect()
            if 'conn' in locals() and conn is not None and conn.is_connected():
                cursor.close()
                conn.close()
            logger.info("已斷開與MQTT Broker和MySQL的連接")

if __name__ == "__main__":
    last_insert_time = {}
    car_data_count = {}
    logger = setup_logger()
    main()