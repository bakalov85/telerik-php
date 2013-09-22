<?php
// Enable display errors
ini_set('display_errors', 1);
ini_set('track_errors', 1);
ini_set('html_errors', 1);
error_reporting(E_ALL);

// Base page title
$config['base_title'] = 'Моите разходи';
// Date format
$config['date_format'] = 'd.m.Y';
// Price format
$config['price_format'] = '%s пари';
// Separator in text files
$config['data_separator'] = '|';
// Minimum length for label string
$config['label_min'] = 4;
// Path to file where the categories are saved
$config['categories_path'] = './data/categories.txt';
// Path to file where the expenses are saved
$config['expenses_path'] = './data/expenses.txt';