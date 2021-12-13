import cfapi

def get_header(data):
    header = ["Ник", "Сумма"]
    for problem in data['problems']:
        header.append(problem['index'])

    header[-1] += '\n'
    return ",,".join(header)

def get_standings(data):
    standings = []
    for team in data['rows']:
        participant = [team['party']['members'][0]['handle']]
        if team['party']['participantType'] == 'PRACTICE':
            participant[0] = '*' + participant[0]
        participant.append(str(int(team['points'])))
        for problem in team['problemResults']:
            result = ""
            if int(problem['points']) == 1:
                result += '+'
            else:
                result += '-'
            participant.append(result)
        standings.append(",,".join(participant))
    return "\n".join(standings)

def update_contests(div):
    for line in open(f"../data/{div}/contests/contests.txt"):
        req = cfapi.authorized_request("contest.standings", [("contestId", line.strip()), ("showUnofficial", "true")])
        if req == None or req['status'] != "OK":
            continue
        data = req['result']
        f = open(f"../data/{div}/contests/{line.strip()}", "w", encoding="utf-8")
        f.write(get_header(data))
        f.write(get_standings(data))
        f.close()
