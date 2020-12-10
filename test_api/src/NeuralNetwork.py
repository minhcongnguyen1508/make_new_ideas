import numpy as np
import time
import pickle


class DeepNeuralNetwork():
    def __init__(self, sizes, epochs=10, l_rate=0.001):
        self.sizes = sizes
        self.epochs = epochs
        self.l_rate = l_rate

        # we save all parameters in the neural network in this dictionary
        self.params = self.initialization()

    def load_model(self, path):
        try:
            with open(path, 'rb') as handle:
                params = pickle.load(handle)
            
            self.params = params
            print("Model is loaded successful!")
        except Exception as e:
            print(e)
            self.params = self.initialization()

    def save_model(self, path):
        with open(path, 'wb') as handle:
            pickle.dump(self.params, handle, protocol=pickle.HIGHEST_PROTOCOL)

    def sigmoid(self, x, derivative=False):
        if derivative:
            return (np.exp(-x))/((np.exp(-x)+1)**2)
        return 1/(1 + np.exp(-x))

    def relu(self, x, derivative=False):
        if derivative:
            x[x<=0] = 0
            x[x>0] = 1
            return x
            # return p.multiply(x, np.int64(z > 0))
        return np.maximum(0, x)

    def softmax(self, x, derivative=False):
        # Numerically stable with large exponentials
        exps = np.exp(x - x.max())
        if derivative:
            return exps / np.sum(exps, axis=0) * (1 - exps / np.sum(exps, axis=0))
        return exps / np.sum(exps, axis=0)

    def initialization(self):
        # number of nodes in each layer
        input_layer=self.sizes[0]
        hidden_1=self.sizes[1]
        hidden_2=self.sizes[2]
        hidden_3=self.sizes[3]
        output_layer=self.sizes[4]

        params = {
            'Weight1':np.random.randn(hidden_1, input_layer) * np.sqrt(1. / hidden_1),
            'Weight2':np.random.randn(hidden_2, hidden_1) * np.sqrt(1. / hidden_2),
            'Weight3':np.random.randn(hidden_3, hidden_2) * np.sqrt(1. / hidden_3),
            'Weight4':np.random.randn(output_layer, hidden_3) * np.sqrt(1. / output_layer)
        }

        return params

    def forward_pass(self, x_train):
        params = self.params

        # input layer activations becomes sample
        params['Activation0'] = x_train

        # input layer to hidden layer 1
        params['Bias1'] = np.dot(params["Weight1"], params['Activation0'])
        params['Activation1'] = self.relu(params['Bias1'])

        # hidden layer 1 to hidden layer 2
        params['Bias2'] = np.dot(params["Weight2"], params['Activation1'])
        params['Activation2'] = self.relu(params['Bias2'])

        # hidden layer 1 to hidden layer 2
        params['Bias3'] = np.dot(params["Weight3"], params['Activation2'])
        params['Activation3'] = self.relu(params['Bias3'])

        # hidden layer 2 to output layer
        params['Bias4'] = np.dot(params["Weight4"], params['Activation3'])
        params['Activation4'] = self.softmax(params['Bias4'])

        return params['Activation4']

    def backward_pass(self, y_train, output):
        '''
            This is the backpropagation algorithm, for calculating the updates
            of the neural network's parameters.

            Note: There is a stability issue that causes warnings. This is 
                  caused  by the dot and multiply operations on the huge arrays.
                  
                  RuntimeWarning: invalid value encountered in true_divide
                  RuntimeWarning: overflow encountered in exp
                  RuntimeWarning: overflow encountered in square
        '''
        params = self.params
        change_w = {}

        # Calculate W4 update
        error = 2 * (output - y_train) / output.shape[0] * self.softmax(params['Bias4'], derivative=True)
        change_w['Weight4'] = np.outer(error, params['Activation3'])

        # Calculate W3 update
        error = np.dot(params['Weight4'].T, error) * self.relu(params['Bias3'], derivative=True)
        change_w['Weight3'] = np.outer(error, params['Activation2'])

        # Calculate W2 update
        error = np.dot(params['Weight3'].T, error) * self.relu(params['Bias2'], derivative=True)
        change_w['Weight2'] = np.outer(error, params['Activation1'])

        # Calculate W1 update
        error = np.dot(params['Weight2'].T, error) * self.relu(params['Bias1'], derivative=True)
        change_w['Weight1'] = np.outer(error, params['Activation0'])

        return change_w

    def update_network_parameters(self, changes_to_w):
        '''
            Update network parameters according to update rule from
            Stochastic Gradient Descent.

            θ = θ - η * ∇J(x, y), 
                theta θ:            a network parameter (e.g. a weight w)
                eta η:              the learning rate
                gradient ∇J(x, y):  the gradient of the objective function,
                                    i.e. the change for a specific theta θ
        '''
        
        for key, value in changes_to_w.items():
            self.params[key] -= self.l_rate * value

    def compute_accuracy(self, x_val, y_val):
        predictions = []

        for x, y in zip(x_val, y_val):
            output = self.forward_pass(x)
            pred = np.argmax(output)
            predictions.append(pred == np.argmax(y))
        
        return np.mean(predictions)

    def train(self, x_train, y_train, x_val, y_val):
        start_time = time.time()

        list_acc = []
        for iteration in range(self.epochs):
            for x,y in zip(x_train, y_train):
                output = self.forward_pass(x)
                changes_to_w = self.backward_pass(y, output)
                self.update_network_parameters(changes_to_w)
            
            accuracy = self.compute_accuracy(x_val, y_val)
            list_acc
            print('Epoch: {0}, Time Spent: {1:.2f}s, Accuracy: {2:.2f}%, learing_rate: {3:.5f}'.format(
                iteration+1, time.time() - start_time, accuracy * 100, self.l_rate
            ))
            self.l_rate /= 1.5

    def predict(self, x_test):
        predict = []
        for x in x_test:
            output = self.forward_pass(x)
            pred = np.argmax(output)
            predict.append(pred)
        return predict