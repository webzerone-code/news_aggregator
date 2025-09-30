-- Good Morning <br/>
this is mvp sample news aggregation app  <br/>
-- the idea <br/>
the hole project idea depend on Async call for the providers in the background to get news from one or more sources <br/>
and process the raw data in another job after that so uses can view the news with there preferences<br/>
-- Installation<br/>
1- configuring the sources  <br/>
please find FetchingDataConfing.php file in the config folder and add modify  its content according to the sources u will read from <br/>
this is sample env config for the parameters fetching data uses<br/>


1- rename env.example file to .env which match my .env file and supply api keys for the first 2 providers and database connections  

2- laravel horizon config <br/>

it has 4 extra jobs 3 for the job fetching queues and one for cleaning the data <br/>
3- add mysql db connection <br/>
4- run migrations <br/>
5- run db CategoriesSeeder.php seed file<br/>
6- running the jobs<br/>
- start horizon run  php artisan horizon<br/>
- start the jobs run php artisan schedule:work<br/>

-- Improvement<br/>

1- use builder pattern in the fetch config instead of calling the parameters directly from config use builder pattern to improve this<br/>
2- in data process its good to update it to use ai to get closest category from the title instead of the current way<br/>
3- the data crawler depending on article tag which may not be accurate for the source it would be good idea to have table or array the links array and its correspond  tage will start crawl from <br/>
4- data process class need some refactor<br/>
