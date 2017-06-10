<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function writeLog($text) {
    
    $GLOBALS['logText'] = $GLOBALS['logText'] . "<br/>" . $text;
    
}

function displayLog() {
    
    echo "Debug Log<p>" . $GLOBALS['logText'];
    
}