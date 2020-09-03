# coding: utf-8
# -*- coding: utf-8 -*-

# 検索クエリ、表示回数、クリック率、掲載順位の表作成

# import pandas as pd
import sys, json

from googleapiclient.discovery import build
from oauth2client.service_account import ServiceAccountCredentials

SCOPES = ['https://www.googleapis.com/auth/webmasters.readonly']

KEY_FILE_LOCATION = sys.argv[1]

credentials = ServiceAccountCredentials.from_json_keyfile_name(KEY_FILE_LOCATION, SCOPES)
webmasters = build('webmasters', 'v3', credentials=credentials)

# CUSTOMER = '天竜精機株式会社'
url = sys.argv[2]

d_list = ['date']
start_date = sys.argv[3]
end_date = sys.argv[4]
row_limit = 5000

body = {
    'startDate': start_date,
    'endDate': end_date,
    'dimensions': d_list,
    'rowLimit': row_limit
}

response = webmasters.searchanalytics().query(siteUrl=url, body=body).execute()
print (json.dumps(response))