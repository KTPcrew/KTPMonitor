import gspread
from oauth2client.service_account import ServiceAccountCredentials

scope = ['https://spreadsheets.google.com/feeds', 'https://www.googleapis.com/auth/drive']
creds = ServiceAccountCredentials.from_json_keyfile_name('secret/gs cred.json', scope)
client = gspread.authorize(creds)

sheet = client.open("Анкета для школьников (Ответы)").sheet1

if __name__ == "__main__":
    print(sheet.get_all_records())