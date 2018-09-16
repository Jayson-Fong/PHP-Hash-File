<?php
function hashes() {
    return array(
        '/Array/Generated/By/Hash/Function.html' => 'a383c4681665fb355719908f0fbae56a'
    );
}
require 'src/hashFile/hashFile.php';
// Place base directory between apostrophes or leave empty for /
$hashFile = new hashFile('');
function getDirectory() {
    echo PHP_EOL . "\e[1;32mCompare Hashes for Directory or File:\e[0m ";
    $handle = fopen ("php://stdin","r");
    $line = fgets ($handle);
    $dir = trim($line);
    if (!is_dir($dir) && !is_file($dir)) {
        echo PHP_EOL . "\e[1;91mInvalid Directory!\e[0m";
        $$dir = getDirectory();
    }
    return $dir;
}
$dir = getDirectory();
if (is_dir($dir)) $hashFile->compareDirectory($dir, hashes());
if (is_file($dir)) $hashFile->compareFile($dir, hashes());
$hashes = $hashFile->getCompareData();
foreach ($hashes as $file => $match) {
    if ($match === 0) echo 'FAILURE: ' . $file . PHP_EOL;
}
echo "Completed!";
