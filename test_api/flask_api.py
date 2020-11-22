from flask import Flask
from flask_restful import Api, Resource
from flask_mysqldb import MySQL
import mysql.connector
from mysql.connector import Error
import datetime
import time

app = Flask(__name__)
# app.config['MYSQL_HOST'] = 'localhost'
# app.config['MYSQL_USER'] = 'medium1'
# app.config['MYSQL_PASSWORD'] = 'scret123'
# app.config['MYSQL_DB'] = 'medium1'

# mysql = MySQL(app)
api = Api(app)

def similarity(sentences, query):
    from sentence_transformers import SentenceTransformer
    # model = SentenceTransformer('xlm-r-100langs-bert-base-nli-mean-tokens')
    model = SentenceTransformer('bert-base-nli-mean-tokens')

    sentence_embeddings = model.encode(sentences)
    # print('Sample BERT embedding vector - length', len(sentence_embeddings[0]))

    import scipy

    queries = [query]
    query_embeddings = model.encode(queries)

    # Find the closest 3 sentences of the corpus for each query sentence based on cosine similarity
    number_top_matches = 5 #@param {type: "number"}

    # print("Semantic Search Results")

    sucess = []
    for query, query_embedding in zip(queries, query_embeddings):
        distances = scipy.spatial.distance.cdist([query_embedding], sentence_embeddings, "cosine")[0]

        results = zip(range(len(distances)), distances)
        results = sorted(results, key=lambda x: x[1])

        # print("\n\n======================\n\n")
        # print("Query:", query)
        # print("\nTop 5 most similar sentences in corpus:")

        for idx, distance in results[0:number_top_matches]:
            # print(sentences[idx].strip(), "(Cosine Score: %.4f)" % (1-distance))
            sucess.append(sentences[idx].strip())
    return sucess

class ConnectDB():
    def __init__(self, host, database, user, password):
        self.host = host
        self.database = database
        self.user = user
        self.password = password
        self.connection = self.connect()

    def connect(self):
        try:
            connection = mysql.connector.connect(host=self.host,
                                         database=self.database,
                                         user=self.user,
                                         password=self.password)
        except Error as e:
            print("Error reading data from MySQL table", e)
        
        return connection

    def get_data_from_table(self, sql_query):
        # connection = self.connect()
        # sql_select_Query_post = "select title from posts"
        results = []
        if (self.connection.is_connected()):
            cursor = self.connection.cursor()
            cursor.execute(sql_query)
            records = cursor.fetchall()
            print("Total number of rows in posts is: ", cursor.rowcount)

            print("\nPrinting each posts record")
            for row in records:
                results.append(row[0])
            cursor.close()
        else:
            print("MySQL is not connection")
        return results

    def conn_close(self):
        if  self.connection.is_connected():
            self.connection.close()
            print("MySQL connection is closed")

    def insert_into_suggestion(self, test1, test2):
        ts = time.time()
        timestamp = datetime.datetime.fromtimestamp(ts).strftime('%Y-%m-%d %H:%M:%S')
        if (self.connection.is_connected()):
            cursor = self.connection.cursor()
            try:
                cursor.execute("""INSERT into suggestion (suggest_id,post_id,created_at,updated_at) values(%s,%s,%s,%s)""",(test1, test2, timestamp, timestamp))
                self.connection.commit()
            except Exception as e:
                print(e)
                self.connection.rollback()
        else:
            print("MySQL is not connection")

    def delete_info_suggestion(self, post_id):
        if (self.connection.is_connected()):
            cursor = self.connection.cursor()
            try:
                sql_Delete_query = """Delete from suggestion WHERE suggest_id=%s;"""%(post_id)
                print(sql_Delete_query)
                cursor.execute(sql_Delete_query)
                self.connection.commit()
            except Exception as e:
                print(e)
        else:
            print("MySQL is not connection")


class HelloWorld(Resource):
    def get(self, post_id):
        # connentDB()
        dataBase = ConnectDB('localhost', 'medium1', 'medium1', 'scret123')
        sent = dataBase.get_data_from_table("select title from posts")
        # print(sent)
        # Similarity 
        query_sent = sent[post_id-1]

        sentenc = similarity(sent, query_sent)
        sql_query = """select id from posts where title='%s';"""%(query_sent)
        id_query = dataBase.get_data_from_table(sql_query)
        print(id_query)
        list_sg = []
        try:
            for i in range(len(sentenc)):
                if i == 0:
                    continue
                sql_query_i = """select id from posts where title='%s';"""%(sentenc[i])
                id_ = dataBase.get_data_from_table(sql_query_i)
                list_sg.append(id_[0])

        except Exception as e:
            print(e)

        dataBase.delete_info_suggestion(post_id)
        for i in list_sg:
            dataBase.insert_into_suggestion(id_query[0], i)

        dataBase.conn_close()
        return {"data": "Success!"}

api.add_resource(HelloWorld, "/helloworld/<int:post_id>")

if __name__ == "__main__":
    app.run(debug=True)