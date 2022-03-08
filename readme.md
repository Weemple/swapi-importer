## Install  
composer require weemple/swapi-importer  
  
## Commands  
sail artisan migrate  
sail artisan swapi:import  
  
## Endpoints  
/api/people  
/api/people/{peopleId}  
  
## Optional Query Strings  
?filter-field=[name]&filter-value=[value]  
?order-field=[name]&order-direction=[asc/desc]
