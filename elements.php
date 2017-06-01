<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$logText = "";
$arrSuffixes = array("ium", "ite", "ide", "ate", "on", "gen", "on");
$arrMarkov = loadMarkov();

$requestParameters = explode('/', trim($_SERVER['PATH_INFO'],'/'));
//var_dump($requestParameters);

$json = "{";

if ($requestParameters[0] == "") {
    $element = createElement($arrMarkov, $arrSuffixes);
    $json = $json . "\"element\":\"" . $element . "\"";
} else {
    for ($e = 1; $e <= $requestParameters[0]; $e++) {
        $element = createElement($arrMarkov, $arrSuffixes);
        $json = $json . "\"element" . $e . "\":\"" . $element . "\"";
        if ($e < $requestParameters[0]) {
            $json = $json . ",";
        }
    }
}

$json = $json . "}";

echo $json;

//displayLog();

// **************************** FUNCTIONS *****************************

function createElement($arrMarkov, $arrSuffixes) {
    
    $prefixLength = rand(3, 7);
    $prefixText = "";
    
    $currentCharacter = chr(rand(97, 122));
    $prefixText = $prefixText . $currentCharacter;
    
    for ($c = 0; $c < $prefixLength; $c++) {
        $arrMarkovPercentages = $arrMarkov[$currentCharacter];
        $arrOccurrences = array();
        foreach ($arrMarkovPercentages as $letter => $value) {
            //writeLog($letter . " follows " . $currentCharacter . " " . $value . "% of the time.");
            for ($l = 0; $l < $value; $l++) {
                array_push($arrOccurrences, $letter);
            }

        }

        shuffle($arrOccurrences);
        
        $selectedCharacter = $arrOccurrences[rand(0, count($arrOccurrences)-1)];
        
        $prefixText = $prefixText . $selectedCharacter;
        
        $currentCharacter = $selectedCharacter;
       
    }
    
    return ucwords($prefixText . $arrSuffixes[rand(0, count($arrSuffixes)-1)]);
    
}

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

function writeLog($text) {
    
    $GLOBALS['logText'] = $GLOBALS['logText'] . "<br/>" . $text;
    
}

function displayLog() {
    
    echo "Debug Log<p>" . $GLOBALS['logText'];
    
}