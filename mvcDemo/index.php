<?php
// index.php file  
include_once("controller/Controller.php");  
  
$controller = new Controller();
$controller->invoke();

//Per PHP7/Zend engine no closing tag