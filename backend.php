<?php

  if (isset($_GET['action'])){

    switch($_GET['action']){

      case "validate":

        $url = $_GET['url'];

        // Check to see if the URL provided contains http://. If not, append it. 
        if ( ( stripos($url,'http://') === false ) && ( stripos($url,'https://') === false ) && ( stripos($url,'ftp://') === false ) ) {
            $url = "http://" . $url;
        }

        // Run a basic validation on the URL
        $valid = ((preg_match('#http\:\/\/[aA-zZ0-9\.]+\.[aA-zZ\.]+#',$url)) || (preg_match('#https\:\/\/[aA-zZ0-9\.]+\.[aA-zZ\.]+#',$url))) ? true : false;


        if ( stripos($url, 'ziz.im') ){ $valid = false; }

        // Output the JSON encoded result. Returning the 'validated' URL for use in the generation process.
        echo json_encode( array('valid' => $valid, 'url' => $url) );
        
        break;

      case "aliascheck":

        $alias = $_GET['alias'];

        $link = mysqli_connect("localhost","root","root","zizim") or die("Error " . mysqli_error($link));

        $alias_check_query = "SELECT * FROM `url` WHERE `alias`='$alias' LIMIT 1" or die("Error checking alias." . mysqli_error($link));

        $alias_check_results = mysqli_query($link, $alias_check_query);

        $valid = (mysqli_num_rows($alias_check_results) > 0) ? false : true;

        mysqli_close($link); 

        // Checks to make sure the alias only contains alphanumeric characters.
        if ( ctype_alnum( $alias) ){
          // Output the JSON encoded result. 
          echo json_encode( array('valid' => $valid) );
        } else {
          // Output the JSON encoded result. 
          echo json_encode( array('valid' => false, 'reason' => "alphanumeric") );
        }

        break;

      case "generate":

        include('functions.php');

        $url = $_GET['url'];
        $shortcode; $alias;

        if (!isset($_GET['alias'])){
          $shortcode = validRandomString();
        } else {
          $alias = $_GET['alias'];
        }

        $shorturl = ($shortcode != "") ? $shortcode : $alias;
        $shorturl = "http://ziz.im/" . $shorturl;

        $ip = $_SERVER['REMOTE_ADDR'];

        // Add to database.      
        $link = mysqli_connect("localhost","root","root","zizim") or die("Error " . mysqli_error($link));

        $add_new_url = "INSERT INTO `url` (`url`, `shortcut`, `alias`, `ip`) VALUES ('$url', '$shortcode', '$alias', '$ip')" or die("Error adding shortcut." . mysqli_error($link));

        echo json_encode( array('original' => $url, 'shortened' => $shorturl) );

        // if (mysqli_query($link, $add_new_url)){
        //   echo json_encode( array('original' => $url, 'shortened' => $shorturl) );
        // } else {
        //   echo json_encode( array('error' => 'Sorry, that didn\'t quite work as planned. Please try again.') );
        // }

        break;

    }

  }

?>