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
// Minimum password length
$config['min_password'] = 5;
// Maximum password length
$config['max_password'] = 60;
// Minimum username length
$config['min_username'] = 5;
// Maximum username length
$config['max_username'] = 60;
// Minimum subject length
$config['min_subject'] = 1;
// Maximum subject length
$config['max_subject'] = 50;
// Minimum message length
$config['min_message'] = 1;
// Maximum message length
$config['max_message'] = 250;
// Date format
$config['date_format'] = 'H:i d.m.Y';

// Database configuration
$config['db']['host'] = 'localhost';
$config['db']['username'] = 'telerik_php';
$config['db']['password'] = 'password';
$config['db']['database'] = 'telerik_php_3_messages';