import csv

host_inds = [19,23,28,21,24,25,36]
listing_inds = [0,19,38,7,86,57,60,52]
amenities_inds = [0,58]

rows = []
title = None
with open('filtered_listings_data.csv') as csv_file:
    csv_reader = csv.reader(csv_file, delimiter=',')
    line_count = 0
    for row in csv_reader:
        new_row = []
        for i in amenities_inds:
            if i == 60 and line_count!=0:
                price = str(row[i]).replace('$','').replace(',','')
                price = int(float(price))
                new_row.append(price)
            elif i == 58 and line_count!=0:
                amenities = str(row[i]).replace('"','').replace('{','').replace('}','')
                new_row.append(amenities)
            else:
                new_row.append(row[i])
        if line_count == 0:
            title = new_row
        else:
            rows.append(new_row)
        line_count+=1


with open('filtered_airbnbamenities_data_cleaned.csv', 'w+') as csv_file:
    writer = csv.writer(csv_file)
    writer.writerow(title)
    writer.writerows(rows)



# for i in range(len(title)):
#     print(title[i], rows[-1][i])
# count = 0
# for col in title:
#     print(count,col)
#     count+=1
#Listing_ID,Host_ID,Location,Description,Rating,Bed_type,Price,Room_type
#Listing_ID,Amenity
#Host_ID,Host_location,Is_superhost,First_name,Description,Response_time,Is_verified
