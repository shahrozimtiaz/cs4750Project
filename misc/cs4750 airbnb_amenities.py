import csv
#import numpy as np

rows = []
title = None
with open('/Users/siddharthsurapaneni/Downloads/filtered_listings_data.csv') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    line_count = 0
    for row in csv_reader:
        if line_count == 10001:
            break
        if line_count == 0:
            title = ['Listing ID','Amenity']
            
        else:
            row[58]=row[58][1:len(row[58])-1]
            amenity_row=row[58].split(",")
            for amenity in amenity_row:
                rows.append([row[0],amenity])
        line_count+=1
with open('new_listing_data.csv', 'w+') as csv_file:
    writer = csv.writer(csv_file)
    writer.writerow(title)
    writer.writerows(rows)
