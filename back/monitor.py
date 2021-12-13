import contest_info
import people_info
import time

minutes_per_update = 15
delay = 60.0 * minutes_per_update

if __name__ == "__main__":
    start = time.time()
    while True:
        contest_info.update_contests()
        people_info.update_people()

        time.sleep(delay - (time.time() - start) % delay)