<?php

  function generateRandomString() {

    $length = 6;
    
    $characters = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    
    for ($p = 0; $p < $length; $p++) {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;

  }

  function validRandomString(){

    $valid = false;
    $shortcode;

    $link = mysqli_connect("localhost","root","root","zizim") or die("Error " . mysqli_error($link));
    
    while ($valid == false){

      $shortcode = generateRandomString();

      $random_string_query = "SELECT * FROM `url` WHERE `shortcut`='$shortcode' LIMIT 1" or die("Error in the consult.." . mysqli_error($link));
      $random_string_results = mysqli_query($link, $url_check_query);
      if (mysqli_num_rows( $random_string_results ) == 0 ){
        $valid = true;
      }

    }

    mysqli_close($link); 

    return $shortcode;

  }

?>