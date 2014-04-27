<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);


//Database Connection
$link = mysqli_connect("localhost","root","root","zizim") or die("Error " . mysqli_error($link));

// IP Address
$ip = $_SERVER['REMOTE_ADDR'];

$query = $_GET['q'];

if ((substr($query, -1) != "$")){

  // If the query isn't to view the tracking details of a URL

  $url_check_query = "SELECT * FROM `url` WHERE `alias`='$query' OR `shortcut`='$query' LIMIT 1" or die("Error in the consult.." . mysqli_error($link));

  $url_check_results = mysqli_query($link, $url_check_query);

  if (mysqli_num_rows($url_check_results) > 0){

    $URL_Info = mysqli_fetch_array($url_check_results);

    $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "N/A";

    $add_tracking_query = "INSERT INTO `track` (`urlID`, `referrer`, `ip`) VALUES ('".$URL_Info['ID']."', '$referrer', '$ip')" or die("Error adding tracking: " . mysqli_error($link));

    $add_tracking = mysqli_query($link, $add_tracking_query);

    // DEBUG
    Header( "HTTP/1.1 301 Moved Permanently" );   
    Header( "Location: " . $URL_Info['url'] );

  } else {

  // If there are no matches, redirect to index.php. Show an appropriate error message. 
  Header( "HTTP/1.1 301 Moved Permanently" );   
  Header( "Location: index.php?error=No+Matches" ); 
  
  }

} else if ((substr($query, -1)) == "$"){

  // include('stats.php');

}

?>

