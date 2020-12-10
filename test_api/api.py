from flask import Flask, request
from flask_restful import Api, Resource
from tensorflow import keras
import time
import pickle
import numpy as np
from src.NeuralNetwork import DeepNeuralNetwork
from src.PreprocessText import read_data, get_label, confus_save
from flask_cors import CORS

app = Flask(__name__)
# api = Api(app)
CORS(app)

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

        print("\n\n======================\n\n")
        print("Query:", query)
        print("\nTop 5 most similar sentences in corpus:")

        for idx, distance in results[0:number_top_matches]:
            print(sentences[idx].strip(), "(Cosine Score: %.4f)" % (1-distance))
            sucess.append(sentences[idx].strip())
    return sucess

def category(query):
    # train_text, train_cat, test_text, test_cat = read_data('src/Data/train.text.en', \
    #     'src/Data/train.cat.en', 'src/Data/test.text.en', \
    #         'src/Data/test.cat.en')

    # dict_ = {}
    # for i in test_cat:
    #     if i not in dict_:
    #         dict_[i] = 0

    # for i in test_cat:
    #     dict_[i] += 1

    # print(dict_)
    # x_train, y_train, x_test, y_test, num_classes, e, t = get_label(train_text, train_cat, test_text, test_cat, save=False)

    dnn = DeepNeuralNetwork(sizes=[1000, 512, 128, 64, 12], epochs=6, l_rate=1)
    dnn.load_model('src/model/model.pkl')

    # loading
    with open('src/model/tokenizer.pkl', 'rb') as handle:
        tokenize = pickle.load(handle)

    end_lable = time.time()
    text_labels = np.load('src/model/encoder.npy')
    # text_labels = e.classes_
    # print("Accuracy: ", dnn.compute_accuracy(x_test, y_test))
    # confus_save(dnn, x_test, y_test, text_labels, 'save_confus.png')

    test_matrix = tokenize.texts_to_matrix([query])
    # test_matrix = t.texts_to_matrix([query])
    results = text_labels[dnn.predict([test_matrix.reshape(1000, 1)])]
    print(results[0])
    return results[0]

@app.route('/suggest_article', methods=['POST'])
def suggest_article():
    input_json = request.get_json(force=True)
    # print("TEST", input_json)
    start = time.time()
    results = ''
    statusCode = "200 Success!"
    try:
        query = input_json["query"]
        sents = input_json["data"]
        results = similarity(sents, query)
    except Exception as e:
        print(e)
        statusCode = "404 Not Found!"

    print("Total time: ", time.time() - start)
    return {"statusCode": statusCode,
            "query": query,
            "result": results,
            }

@app.route('/suggest_category', methods=['POST'])
def suggest_category():
    input_json = request.get_json(force=True)
    statusCode = "200 Success!"
    results = ''
    start = time.time()
    try:
        query = input_json["query"]
        results = category(query)
        print("Query: ", query)
    except Exception as e:
        print(e)
        statusCode = "404 Not Found!"
    
    print("Total time: ", time.time() - start)
    return {"statusCode": statusCode,
            "query": query,
            "category": results,
            }

if __name__ == "__main__":
    app.run(port=12345 ,debug=True)

