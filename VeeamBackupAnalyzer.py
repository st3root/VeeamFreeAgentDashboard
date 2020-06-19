#!/usr/bin/python

# !!! SORRY for the messy code, I'm not a programmer

import email, imaplib
import mysql.connector
import datetime

#eMail connection
username = 'pcbackups@example.com'
password = 'emailpassword'
imap = imaplib.IMAP4_SSL('192.168.1.100')
imap.login(username, password)
imap.select("Inbox")

now = str(datetime.datetime.now())
day = str(datetime.date.today())

#MySQL
mydb = mysql.connector.connect(
  host="localhost",
  user="pi",
  passwd="raspberry",
  database="pcbv2"
)
mycursor = mydb.cursor()

# MySQL write
def mysqlWrite(pcname,status,message):
		global now
		sql = "INSERT INTO pc (pcname,status,date) VALUES (%s, %s, %s) ON DUPLICATE KEY UPDATE status = %s, date = %s"
		val = (pcname, status, now, status, now)
		mycursor.execute(sql, val)
		sqlmsg = "INSERT INTO messages (pcname,message) VALUES (%s, %s)"
		valmsg = (pcname, message)
		mycursor.execute(sqlmsg, valmsg)
		mydb.commit()

resp, items = imap.search(None, "UNSEEN")

for n, num in enumerate(items[0].split(), 1):
	resp, data = imap.fetch(num, '(RFC822)')

	body = data[0][1]
	msg = email.message_from_string(body)
	content = msg.get_payload(decode=True)

#    print(content)
	start = content.find("Backup Job ") + len("Backup Job ")
	end = content.find('<div class="jobDescription"')
	pcname = content[start:end]
	if pcname.endswith(" (Retry)"):
		pcname = pcname[:-8]
	if pcname.endswith(" (Full)"):
		pcname = pcname[:-7]
#    print(content)
	if "#00B050" in content:
	#	print("Success")
		status = 1
	elif "#ffd96c" in content:
	#	print("Warning")
		status = 2
	elif "#fb9895" in content:
	#	print("Failure")
		status = 3
	else:
	#	print("No status data")
		status = 0
	#print(pcname)
#write data to mysql DB
	mysqlWrite(pcname,status,content)

