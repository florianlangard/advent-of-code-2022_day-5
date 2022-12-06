<?php

$rawData = file_get_contents('sample.txt');
$data = explode("\n\n", $rawData);

$cratesString = $data[0];
$moveInstructionsString = $data[1];

// Trying to get the crates layout here...

$cratesLayout = explode("\n", $cratesString);
array_pop($cratesLayout);
$invertedCratesLayout = array_reverse($cratesLayout);

$index = 0;
foreach ($invertedCratesLayout as $row) {

    $rows[$index] = str_split($row, 4);
    $index++;
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

// var_dump($invertedCratesLayout);
var_dump($finalArray);

// Dealing with the move instructions now...

$separatedInstructions = explode("\n", $moveInstructionsString);

foreach ($separatedInstructions as $singleInstruction) {
    # code
    $inter = explode("move ", $singleInstruction);
    array_shift($inter);
    $inter2 = explode(" from ", $inter[0]);
    $inter3 = explode(" to ", $inter2[1]);
    $instruction["move"] = $inter2[0];
    $instruction["from"] = $inter3[0];
    $instruction["to"] = $inter3[1];
    $instructions[] = $instruction;
}
var_dump($instructions);