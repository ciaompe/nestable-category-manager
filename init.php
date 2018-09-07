<?php

/*
Display errors turn on
*/
ini_set('display_errors', 'On');

/*
Import configuration lib
*/
use Noodlehaus\Config;

/*
Import Helpers to the application
 */
use Ciaompe\Helpers\Database;
use Ciaompe\Helpers\Category;

//Load Composer Packages
require 'vendor/autoload.php';

//Load System Configurtions from config.php file
$config = Config::load('config.php');

//Twig Cofiguration
$loader = new Twig_Loader_Filesystem('system/templates');
$twig = new Twig_Environment($loader);

//Make Database Connection
$db =  new Database($config);

$cat = new Category();

