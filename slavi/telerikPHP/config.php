<?php
//new array for default category
$defaultCategory = array();

$defaultCategory[1] = "Food";
$defaultCategory[2] = "Transport";
$defaultCategory[3] = "Others";
$defaultCategory[4] = "Clothes";
//define database files
define("USER_EXPENSE", 'database' . DIRECTORY_SEPARATOR . 'userExpense.txt');
define("CATEGORY", 'database' . DIRECTORY_SEPARATOR . 'category.txt');