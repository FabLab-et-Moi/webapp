<?php

// website name/title
$title = "FabLab & Moi";

// messages to display per page
$per_page = 10;

// Timezone to use (default to UTC)
// For example UTC, Asia/Kathmandu, America/New_York
$timezone = "Europe/Paris";
date_default_timezone_set($timezone);

// database server credientials


//connection between php and mysql (Do not change this!!!)
$dbconnect = new mysqli($hostname,$hostuser,$hostpass,$dbname);

// Create the required table in the database
// CREATE TABLE `<dbname>`.`<tablename>` (`id` INT AUTO_INCREMENT PRIMARY KEY, `name` VARCHAR(60) NOT NULL, `message` TEXT(600) NOT NULL, `date` DATETIME DEFAULT NOW() NOT NULL) AUTO_INCREMENT=1;
