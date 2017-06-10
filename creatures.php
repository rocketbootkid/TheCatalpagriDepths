<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include ("functions/markov_functions.php");
include ("functions/log_functions.php");

$logText = "";
$arrSuffixes = array("pod", "saur", "ped", "phore", "acanth", "avis", "derm", "form", "pus", "stome", "rex");
$arrMarkov = loadMarkov();

$requestParameters = explode('/', trim($_SERVER['PATH_INFO'],'/'));
//var_dump($requestParameters);

$json = "{";

if ($requestParameters[0] == "") {
    $element = createElement($arrMarkov, $arrSuffixes);
    $json = $json . "\"element\":\"" . $element . "\"";
} else {
    for ($e = 1; $e <= $requestParameters[0]; $e++) {
        $element = createCreature($arrMarkov, $arrSuffixes);
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

function createCreature($arrMarkov, $arrSuffixes) {
    
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