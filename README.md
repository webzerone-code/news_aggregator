-- Good Morning 
this is mvp sample news aggregation app  
-- the idea 
the hole project idea depend on Async call for the providers in the background to get news from one or more sources 
and process the raw data in another job after that so uses can view the news with there preferences
-- Installation
1- configuring the sources  
please find FetchingDataConfing.php file in the config folder and add modify  its content according to the sources u will read from <br/>
this is sample env config for the parameters fetching data uses

API_KEY_OPEN_API_KEY=
API_KEY_OPEN_API_URL=https://newsapi.org/v2/everything
API_KEY_OPEN_API_SOURCES=bbc-news,new-york-times,cnn,usa-today,the-wall-street-journal,bloomberg,the-verge,reuters
API_KEY_OPEN_API_SORT=publishedAt
API_KEY_OPEN_API_LANGUAGE=en
API_KEY_OPEN_API_PARSE_PER_PAGE=100
API_KEY_OPEN_API_MAX_PAGES=10
API_KEY_OPEN_API_TIME_INTERVALS=2160
API_KEY_OPEN_API_FULL_BACK_DB_CHECK=24
######
API_KEY_GUARDIAN_API_KEY=
API_KEY_GUARDIAN_API_URL=https://content.guardianapis.com/search
API_KEY_GUARDIAN_API_SORT=publishedAt
API_KEY_GUARDIAN_API_LANGUAGE=en
API_KEY_GUARDIAN_API_FIELDS=headline,body,bodyText,thumbnail
API_KEY_GUARDIAN_API_PARSE_PER_PAGE=10
API_KEY_GUARDIAN_API_MAX_PAGES=10
API_KEY_GUARDIAN_API_TIME_INTERVALS=2160
API_KEY_GUARDIAN_API_FULL_BACK_DB_CHECK=24
#####
API_KEY_BBC_API_URL=http://feeds.bbci.co.uk/news/rss.xml
API_KEY_BBC_API_FULL_BACK_DB_CHECK=24
-- 

2- laravel horizon config 

it has 4 extra jobs 3 for the job fetching queues and one for cleaning the data 
3- configure the .env file QUEUE_CONNECTION to work with raids 
4- add mysql db connection 
5- run migrations 
6- run db CategoriesSeeder.php seed file
5- running the jobs
- start horizon run  php artisan horizon
- start the jobs run php artisan schedule:work

-- Improvement

1- use builder pattern in the fetch config instead of calling the parameters directly from config use builder pattern to improve this
2- in data process its good to update it to use ai to get closest category from the title instead of the current way
3- the data crawler depending on article tag which may not be accurate for the source it would be good idea to have table or array the links array and its correspond  tage will start crawl from 
4- data process class need some refactor
5- adding user perfectness route to store user preferences so loading the data according to his/here preferences 
