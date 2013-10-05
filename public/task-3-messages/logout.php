<?php
include './app/config.php';
include './app/utilities.php';

session_destroy();

redirect_to('index');

