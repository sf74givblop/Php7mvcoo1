<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">        
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
        <meta content="no-cache,no-store,must-revalidate,max-age=-1" http-equiv="Cache-Control">
        <meta content="no-cache,no-store" http-equiv="Pragma">
        <meta content="-1" http-equiv="Expires">
        <meta content="Serge M Frezier" name="Author">
        <meta content="INDEX,FOLLOW" name="robots">
        <meta content="" name="keywords">
        <meta content="" name="description">
        <meta name="author" content="Serge M Frezier">  
        <meta name="mobile-web-app-capable" content="yes">
        
        <title>PHP7 MVC OO 1</title>
        
        <link type="image/x-icon" rel="shortcut icon" href="assets/img/favicon.ico" />
        <link type="image/x-icon" rel="shortcut icon" sizes="196x196" href="assets/img/nice-highres.png" />
        
        <link rel="stylesheet" type="text/css" media="all" href="assets/stylesheets/bootstrap.css" /> 
    </head>
    <body>
        PATTERNS and CLASSES
        <br />
        <br />
        <br />
        1) An example of OO in php: Class, extension, sub-classes, inheritance, __construct, function, overwriting, and more
        <br/>
        <br/>
        <?php
        // put your code here
        require_once 'classFish.php';
        echo "From subclass:" . " " . $brook_trout->getInfo();
        //From subclass: Brook Trout tastes Delicious. The record Brook Trout weighed 14 pounds 8 ounces. 
        ?>
        <br/>
        <br/>        
        2) An example of OO in php: Class, Factory pattern, sub-classes, inheritance, __construct, function, overwriting, and more
        <br/>
        <br/>
        <?php
        // Same thing using a Model Factory
        require_once 'classFishWithFactory.php';
        echo "From Factory pattern: ". $riverFish_1->getAllInfo(); 
        // outputs "From Factory pattern: The Trout Brook is an awesome fish. It is very Delicious when eaten. Currently the world record Trout weighed 14 pounds 8 ounces.";
        ?>
    </body>
</html>
