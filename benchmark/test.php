<?php
require_once __DIR__ . '/../src/CodiceFiscale.php';

use NigroSimone\CodiceFiscale;

$sampleCodes = [
    "DLCFNC01L46H50MJ",
    "LMRBHM74A01Z3P0U",
    "CNTPTR60C29H5L1W",
    "MRARSS75P14H501I",
    "MRARSS82M56F205J",
    "LRNCST94B08F104C",
    "LRNCST94B08F10QZ",
    "LRNCST94B08F1L4N",
    "LRNCST94B08FM04U",
    "LRNCST94B0UF104Z",
    "LRNCSTV4B08F104R",
    "LRNCST94BL8F1LQV",
    "LRNCSTVQB08F10QA",
    "LRNCSTVQBLUFMLQL",
    "BDLMMD80B13Z33SK",
    "RSSLRA80A41H501X"
];

$codes = [];
for ($i = 0; $i < 1000000; $i++) {
    $codes[] = $sampleCodes[$i % count($sampleCodes)];
}

$cf = new CodiceFiscale();

$start = microtime(true);

$validCount = 0;
foreach ($codes as $code) {
    if ($cf->validaCodiceFiscale($code)) {
        $validCount++;
    }
}

$end = microtime(true);
$duration = $end - $start;

echo "Validated " . count($codes) . " codes in {$duration} seconds.\n";
echo "Valid codes: {$validCount}\n";

/*
Validated 1000000 codes in 3.4089179039001 seconds.
Valid codes: 1000000
*/