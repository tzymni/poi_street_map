# Address POI from OpenStreetMap - REST API
A simple REST api created in PHP and designed to generate adresses data from OpenStreetMap api based on given longtitude and latitude can be used for reading, inputing or deleting data from mysql database

Instalation:
1. Clone repository
2. Create database and import poi_table.sql
3. Change connection settings in api/config/database.php
4. Test by Postman


Add POI:
api/poi/add.php
form-data: name, lat, lng

Read all active POIS:
api/poi/read.php

Delete POI:
api/poi/delete.php 
form-data: id
