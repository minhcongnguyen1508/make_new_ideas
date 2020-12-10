from NeuralNetwork import DeepNeuralNetwork
from PreprocessText import read_data, get_label

if __name__ == "__main__":
    train_text, train_cat, test_text, test_cat = read_data('Data/train.text.en', 'Data/train.cat.en', 'Data/test.text.en', 'Data/test.cat.en')
    x_train, y_train, x_test, y_test, num_classes, encode, tokenize = get_label(train_text, train_cat, test_text, test_cat)
    dnn = DeepNeuralNetwork(sizes=[1000, 512, 128, 64, 12], epochs=20, l_rate=1)
    dnn.train(x_train, y_train, x_test, y_test)

    dnn.save_model('model/model.pkl')