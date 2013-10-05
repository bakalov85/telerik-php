<?php
// Enable display errors
ini_set('display_errors', 1);
ini_set('track_errors', 1);
ini_set('html_errors', 1);
error_reporting(E_ALL);

// Start session before anything send to buffer
session_start();

// Set default encoding
mb_internal_encoding('UTF-8');


// Base page title
$config['base_title'] = 'Размяна на съобщения';
// What stays between page title and base title
$config['base_title_separator'] = ' | ';
$config['min_password'] = 5;
$config['max_password'] = 60;
$config['min_username'] = 5;
$config['max_username'] = 60;
$config['min_subject'] = 1;
$config['max_subject'] = 50;
$config['min_message'] = 1;
$config['max_message'] = 250;
$config['date_format'] = 'H:i d.m.Y';
$config['db']['host'] = 'localhost';
$config['db']['username'] = 'telerik_php';
$config['db']['password'] = 'password';
$config['db']['database'] = 'telerik_php_3_messages';