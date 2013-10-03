<?php
// Enable display errors
ini_set('display_errors', 1);
ini_set('track_errors', 1);
ini_set('html_errors', 1);
error_reporting(E_ALL);

// Start session before anything send to buffer
session_start();

// Base page title
$config['base_title'] = 'Моите файлове';
// What stays between page title and base title
$config['base_title_separator'] = ' | ';
// Separator in text files
$config['data_separator'] = '|';
// Path to file where the expenses are saved
$config['users_path'] = './data/users.txt';
// Path to userfiles
$config['files_path'] = './data/files';
// Path to userfiles
$config['max_filename'] = 64;


/*
// Date format
$config['date_format'] = 'd.m.Y';
// Price format
$config['price_format'] = '%s пари';
// Minimum length for label string
$config['label_min'] = 4;
// Path to file where the categories are saved
$config['categories_path'] = './data/categories.txt';
 */