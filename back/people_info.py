import gsapi

div_to_row = {'B': 3, 'C': 2, 'D': 1}

def get_people(div):
    ret = set()
    names = gsapi.get_data("Списки и расписание", 1, [div_to_row[div]])
    for name in names[0][1:]:
        ret.add(name.strip())
    return ret

def update_people(div):
    gsapi.authorize()
    names = get_people(div)
    #имя,,ник,,возраст,,школа,,класс,,город
    columns = [2, 8, 4, 6, 7, 5]
    data = gsapi.get_data("Анкета для школьников (Ответы)", 0, columns)
    info = []
    for i in range(len(data[0])):
        if data[0][i].strip() not in names:
            continue
        info.append([])
        for j in range(len(columns)):
            info[-1].append(data[j][i])
        info[-1] = ",,".join(info[-1])
    # print(data)
    f = open(f"../data/{div}/people/students.txt", "w", encoding="utf8")
    f.write("\n".join(info))
    f.close()
    