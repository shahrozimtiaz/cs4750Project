import csv
import numpy as np

rows = []
title = None
with open('airbnb_listings.csv') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    line_count = 0
    for row in csv_reader:
        if line_count == 10001:
            break
        if line_count == 0:
            title = row
        else:
            rows.append(row)
        line_count+=1
with open('filtered_listings_data.csv', 'w+') as csv_file:
    writer = csv.writer(csv_file)
    writer.writerow(title)
    writer.writerows(rows)
