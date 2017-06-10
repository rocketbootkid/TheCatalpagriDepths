<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function loadMarkov() {
    
    $fileContents = file_get_contents("output.json");
    
    $sortedMarkov = sortMarkov(json_decode($fileContents, true));
    
    return $sortedMarkov;
    
}

function sortMarkov($arrMarkov) {
    
    // For each main character, remove blank entries and sort in descending order
    
    for ($c = 97; $c <= 122; $c++) {
        $character = chr($c);
        //writeLog("First Character: " . $character);
        
        for ($s = 97; $s <= 122; $s++) {
            $secondCharacter = chr($s);
            //writeLog("Second Character: " . $secondCharacter);
            
            //writeLog("Count: " . $arrMarkov[$character][$secondCharacter]);
            
            if ($arrMarkov[$character][$secondCharacter] == 0) {
                unset($arrMarkov[$character][$secondCharacter]);
            }
        }
        
        arsort($arrMarkov[$character]);
    }
    
    return $arrMarkov;
    
}