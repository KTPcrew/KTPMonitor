import contest_info
import people_info
import time

minutes_per_update = 15
delay = 60.0 * minutes_per_update
divs = ['B', 'C', 'D']

if __name__ == "__main__":
    start = time.time()
    while True:
        for div in divs:
            contest_info.update_contests(div)
            people_info.update_people(div)
            people_info.update_stats(div)

        time.sleep(delay - (time.time() - start) % delay)
