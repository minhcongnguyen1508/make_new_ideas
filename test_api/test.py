from src.NeuralNetwork import DeepNeuralNetwork
from src.PreprocessText import read_data, get_label

def suggest_category(query):
    # input_json = request.get_json(force=True)
    # query = input_json["query"]
    train_text, train_cat, test_text, test_cat = read_data('src/Data/train.text.en', \
        'src/Data/train.cat.en', 'src/Data/test.text.en', \
            'src/Data/test.cat.en')

    x_train, y_train, x_test, y_test, num_classes, encode, tokenize = get_label(train_text, train_cat, test_text, test_cat)


    dnn = DeepNeuralNetwork(sizes=[1000, 512, 128, 64, 12], epochs=6, l_rate=1)
    dnn.load_model('src/test_2.pkl')
    print(dnn.compute_accuracy(x_test, y_test))
    text_labels = encode.classes_
    test_matrix = tokenize.texts_to_matrix(query)
    dnn.predict(test_matrix.reshape(1000, 1))
    result = text_labels[dnn.predict(test_matrix.reshape(1000, 1))]
    print(result)
    # return {"statusCode": statusCode,
    #         "query": query,
    #         "category": results,
    #         }

if __name__ == "__main__":
    suggest_category(["four years away  lord of the rings director peter jackson has said that it will be up to four years before he starts work on a film version of the hobbit."])