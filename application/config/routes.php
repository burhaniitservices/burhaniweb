<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'pages';
// $route['(:any)'] = 'pages/index/$1';
$route['/'] = 'pages/index';
$route['/home'] = 'pages/index';

$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
