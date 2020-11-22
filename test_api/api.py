import requests
import sys

TEST = "http://127.0.0.1:5000/"
arg = sys.argv

response = requests.get(TEST + "helloworld/" + arg[1])
print(response.json())

