import requests

TEST = "http://127.0.0.1:5000/"

response = requests.get(TEST + "helloworld")

print(response.json())


# def connentDB():
#     try:
#         connection = mysql.connector.connect(host='localhost',
#                                          database='medium1',
#                                          user='medium1',
#                                          password='scret123')

#         sql_select_Query_post = "select title from posts"
#         cursor = connection.cursor()
#         cursor.execute(sql_select_Query_post)
#         records = cursor.fetchall()
#         print("Total number of rows in posts is: ", cursor.rowcount)

#         print("\nPrinting each laptop record")
#         sent = []
#         for row in records:
#             sent.append(row[0])
#             # print("Title  = ", row, "\n")

#     except Error as e:
#         print("Error reading data from MySQL table", e)
#     finally:
#         if (connection.is_connected()):
#             connection.close()
#             cursor.close()
#             print("MySQL connection is closed")
#     return sent