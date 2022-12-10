<?php

$rawData = file_get_contents('data.txt');
$data = explode("\n\n", $rawData);

$cratesString = $data[0];
$moveInstructionsString = $data[1];

// Trying to get the crates layout here...
$cratesLayout = explode("\n", $cratesString);
array_pop($cratesLayout);
$invertedCratesLayout = array_reverse($cratesLayout);

$i = 0;
foreach ($invertedCratesLayout as $row) {
    $rows[$i] = str_split($row, 4);
    $i++;
}

$i = 0;
foreach ($rows as $singleRow) {
    $defRow = [];
    foreach ($singleRow as $item ) {
        $inter = substr($item, 1,1);
        $defRow[] = $inter;
    }
    $finalArray[$i] = $defRow;
    $i++;
}

$orderedWarehouse = [];

for ($i=0; $i < count($finalArray[0]); $i++) {
    $orderedPile = [];
    foreach ($finalArray as $unorderedPile) {
        $orderedPile[] = $unorderedPile[$i];
    }
    $orderedWarehouse["Stack "."$i"+1] = $orderedPile;
}

// Popping empty items :
$finalWarehouse = [];
$index = 1;

foreach ($orderedWarehouse as $stack ) {
    while (end($stack) === null || end($stack) === " ") {
        array_pop($stack);
    }
    $finalWarehouse["stack ".$index] = $stack;
    $index++;
}
$warehouse = $finalWarehouse;

// Dealing with the move instructions now...
$separatedInstructions = explode("\n", $moveInstructionsString);

foreach ($separatedInstructions as $singleInstruction) {
    $inter = explode("move ", $singleInstruction);
    array_shift($inter);
    $inter2 = explode(" from ", $inter[0]);
    $inter3 = explode(" to ", $inter2[1]);
    $instruction["move"] = $inter2[0];
    $instruction["from"] = $inter3[0];
    $instruction["to"] = $inter3[1];
    $instructions[] = $instruction;
}

// Finally! Let's work!

//========== Part One, Crate Mover 9000 Go! ==============

// foreach ($instructions as $instruction ) {
//     $pick = "stack ".$instruction["from"];
//     $dest = "stack ".$instruction["to"];
//     $count = intval($instruction["move"]);
//     for ($i=0; $i < $count; $i++) { 

//         $crate = end($warehouse[$pick]);
//         array_pop($warehouse[$pick]);
//         $warehouse[$dest][] = $crate;
//     }
// }

// $message = [];
// foreach ($warehouse as $stack ) {
//     $message[] = end($stack);
// }
// $key = implode("", $message);

//=========== tada! ==============

// var_dump("message : ".$key);

//========== Part Two, Crate Mover 9001 upgrade! ==============

// Work !
foreach ($instructions as $instruction ) {
    $pick = "stack ".$instruction["from"];
    $dest = "stack ".$instruction["to"];
    $count = intval($instruction["move"]);

    $midStep = [];
    for ($i=0; $i < $count; $i++) {    
        $crate = end($warehouse[$pick]);
        array_pop($warehouse[$pick]);
        array_unshift($midStep, $crate);
    }
    for ($j=0; $j < count($midStep); $j++) {
        $interCrate = $midStep[$j];
        $warehouse[$dest][] = $interCrate;
    }
    
}

$message = [];
foreach ($warehouse as $stack ) {
    $message[] = end($stack);
}
$key = implode("", $message);

//=========== tada! ==============

var_dump("message : ".$key);