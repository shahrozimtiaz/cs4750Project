getwd()
library(tidyverse) #loading the packages that will be used
library(fastDummies)
df<-read.csv('filtered_arrests_data.csv')
df<-select(df,ARREST_KEY,ARREST_DATE,PD_DESC,PERP_SEX,AGE_GROUP,PERP_RACE)

write.csv(df,"ArrestDB.csv", row.names = FALSE)