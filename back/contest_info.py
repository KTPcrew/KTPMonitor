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
    contest_info = []
    contest_info.append("Название,,ID,,Создатель,,Длительность")
    with open(f"../data/{div}/contests/contest_ids.txt", "r", encoding="utf-8") as f:
        lines = f.readlines()
    for line in lines:
        req = cfapi.authorized_request("contest.standings", [("contestId", line.strip()), ("showUnofficial", "true")])
        if req == None or req['status'] != "OK":
            continue
        data = req['result']
        with open(f"../data/{div}/contests/{line.strip()}", "w", encoding="utf-8") as f:
            f.write(get_header(data))
            f.write(get_standings(data))
        
        data = data['contest']
        contest_info.append(f"{data['name']},,{data['id']},,{data['preparedBy']},,{int(data['durationSeconds']) // 3600}")

    with open(f"../data/{div}/contests/descriptions.txt", "w", encoding="utf-8") as f:
        f.write("\n".join(contest_info))
