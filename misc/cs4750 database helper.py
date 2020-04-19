import mysql.connector

cnx = mysql.connector.connect(user='root',
                              host='127.0.0.1',
                              database='mysql',
                              use_pure=False)
cursor = cnx.cursor()

query = ("SELECT * FROM user;")

cursor.execute(query)

for row in cursor:
    print(row)

cursor.close()
cnx.close()