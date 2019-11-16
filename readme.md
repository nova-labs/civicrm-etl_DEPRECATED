Built using <p align="center"><img src="https://res.cloudinary.com/dtfbvvkyp/image/upload/v1566331377/laravel-logolockup-cmyk-red.svg" width="400"></p>



## About Civic ETL

The basic idea of this is to build a console application that hooks into the legacy Spaceman database.  The data is stored in a local database and can be further manipulated and edited. Finally, the data can be loaded into Nova Labs Civicrm instance.


## Getting the data out of Spaceman

There are three scripts that are used to pull Users (people table), Groups and Group Membership (people_group). 


## Editing data

Might be scripts or a web interface


## Inserting into Civicrm

Idea is to pull out of the database and push into Civicrm via the API.  


## Split site development 

By putting this code within a database as the transfer platform, the extraction and insertion can be done on different machines, by different people and at different times.  


## License

The Laravel framework is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).
