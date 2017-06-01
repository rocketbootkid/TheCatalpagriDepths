<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include ("functions/curl_functions.php");

$url = "http://localhost/thecatalpagridepths/elements/5";

var_dump( curlRequest($url));   
