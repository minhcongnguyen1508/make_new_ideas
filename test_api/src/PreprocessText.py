import matplotlib.pyplot as plt
import numpy as np
import pandas as pd
from sklearn.preprocessing import LabelBinarizer, LabelEncoder
from tensorflow import keras
from sklearn.metrics import confusion_matrix
import itertools
import os
import pickle

def read_data(train_text_file, train_cat_file, test_text_file, test_cat_file):
  import codecs

  f1 = codecs.open(train_text_file, 'r', 'utf-8')
  f2 = codecs.open(train_cat_file, 'r', 'utf-8')
  f3 = codecs.open(test_text_file, 'r', 'utf-8')
  f4 = codecs.open(test_cat_file, 'r', 'utf-8')
  train_text = []
  train_cat = []
  test_text = []
  test_cat = []
  for line in f1:
    line = line.strip()
    train_text.append(line)
  for line in f2:
    line = line.strip()
    train_cat.append(line)
  for line in f3:
    line = line.strip()
    test_text.append(line)
  for line in f4:
    line = line.strip()
    test_cat.append(line)

  return  train_text, train_cat, test_text, test_cat

def train_test_split(data, train_size):
    train = data[:train_size]
    test = data[train_size:]
    return train, test

def _append_data(data, key):
  data_text = []
  for i in range(len(data[key])):
    data_text.append(data[key][i])

  return data_text

def preprocess(data):
  data_text = _append_data(data, 'text')
  data_cat = _append_data(data, 'category')

  train_cat, test_cat = train_test_split(data_cat, train_size)
  train_text, test_text = train_test_split(data_text, train_size)
  
  # return data_text, data_cat
  return train_text, train_cat, test_text, test_cat

def get_label(train_text, train_cat, test_text, test_cat, max_words = 1000, save=True, encoder_path='model/encoder', tokenizer_path='model/tokenizer.pkl'):
  tokenize = keras.preprocessing.text.Tokenizer(num_words=max_words, char_level=False)
  tokenize.fit_on_texts(train_text) # fit tokenizer to our training text data
  
  x_train = tokenize.texts_to_matrix(train_text)
  x_test = tokenize.texts_to_matrix(test_text)
  encoder = LabelEncoder()
  encoder.fit(train_cat)
  if save:
    np.save(encoder_path, encoder.classes_)
    with open(tokenizer_path, 'wb') as handle:
      pickle.dump(tokenize, handle, protocol=pickle.HIGHEST_PROTOCOL)
  y_train = encoder.transform(train_cat)
  y_test = encoder.transform(test_cat)
  # Converts the labels to a one-hot representation
  print("Number labels: " ,np.max(y_train) + 1)
  num_classes = np.max(y_train) + 1
  y_train = keras.utils.to_categorical(y_train, num_classes)
  y_test = keras.utils.to_categorical(y_test, num_classes)
  print('x_train shape:', x_train.shape)
  print('x_test shape:', x_test.shape)
  print('y_train shape:', y_train.shape)
  print('y_test shape:', y_test.shape)
  return x_train, y_train, x_test, y_test, num_classes, encoder, tokenize

def run_experiment(x_train, y_train, x_test, y_test, batch_size, epochs, drop_ratio, num_classes, max_words=1000):
  layers = keras.layers
  models = keras.models

  print('batch size: {}, epochs: {}, drop_ratio: {}'.format(
      batch_size, epochs, drop_ratio))
  model = models.Sequential()
  model.add(layers.Dense(512, input_shape=(max_words,)))
  model.add(layers.Activation('relu'))
  model.add(layers.Dropout(drop_ratio))
  model.add(layers.Dense(num_classes))
  model.add(layers.Activation('softmax'))

  model.compile(loss='categorical_crossentropy',
                optimizer='adam',
                metrics=['accuracy'])
  history = model.fit(x_train, y_train,
                    batch_size=batch_size,
                    epochs=epochs,
                    verbose=0,
                    validation_split=0.1)
  score = model.evaluate(x_test, y_test,
                       batch_size=batch_size, verbose=0)
  print('\tTest loss:', score[0])
  print('\tTest accuracy:', score[1])

  return model

def test_model(model, x_test, y_test):
  y_pred_1d = model.predict(x_test)
  y_test_1d = []
  for i in range(len(y_test)):
    probs = y_test[i]
    index_arr = np.nonzero(probs)
    one_hot_index = index_arr[0].item(0)
    y_test_1d.append(one_hot_index)

  print(y_test_1d[0], y_pred_1d[0])
  return y_test_1d, y_pred_1d

def plot_confusion_matrix(cm, classes,
                          title='Confusion matrix',
                          cmap=plt.cm.Blues):
  # cm = cm.astype('float') / cm.sum(axis=1)[:, np.newaxis]

  plt.imshow(cm, interpolation='nearest', cmap=cmap)
  plt.title(title, fontsize=30)
  plt.colorbar()
  tick_marks = np.arange(len(classes))
  plt.xticks(tick_marks, classes, rotation=90, fontsize=12)
  plt.yticks(tick_marks, classes, fontsize=12)
  fmt = '.2f'
  thresh = cm.max() / 2.
  for i, j in itertools.product(range(cm.shape[0]), range(cm.shape[1])):
    plt.text(j, i, format(cm[i, j], fmt),
               horizontalalignment="center",
               color="white" if cm[i, j] > thresh else "black")
  plt.ylabel('True label', fontsize=25)
  plt.xlabel('Predicted label', fontsize=25)

def confus_save(model, x_test, y_test, text_labels, path):
  y_test_1d, y_pred_1d = test_model(model, x_test, y_test)
  cnf_matrix = confusion_matrix(y_test_1d, y_pred_1d)
  plt.figure(figsize=(14,14))
  plot_confusion_matrix(cnf_matrix, classes=text_labels, title="Confusion matrix")
  plt.show()
  plt.savefig(path)