import requests
import pprint

pref = "https://codeforces.com/api/"


pprint.pprint(requests.get(pref + "contest.status?contestId=566&from=1&count=10").json())