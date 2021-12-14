import contest_info
import people_info
import time

minutes_per_update = 15
delay = 60.0 * minutes_per_update
divs = ['B', 'C', 'D']

if __name__ == "__main__":
    a = 0
    print(5 / a)
    start = time.time()
    while True:
        for div in divs:
            people_info.update_people(div)
            contest_info.update_contests(div)

        time.sleep(delay - (time.time() - start) % delay)
