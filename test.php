<?php
require 'src/hashFile/hashFile.php';
// Place base directory between apostrophes or leave empty for /
$hashFile = new hashFile('');
function getDirectory() {
    echo PHP_EOL . "\e[1;32mGet Hashes for Directory or File:\e[0m ";
    $handle = fopen ("php://stdin","r");
    $line = fgets ($handle);
    $dir = trim($line);
    if (!is_dir($dir) && !is_file($dir)) {
        echo PHP_EOL . "\e[1;91mInvalid Directory!\e[0m";
        $$dir = getDirectory();
    }
    return $dir;
}
$hashFile->hashDirectoryFiles(getDirectory());
$hashes = $hashFile->getHashes();
foreach ($hashes as $file => $hash) {
        echo '\'' . $file . '\' => \'' . $hash . '\',' . PHP_EOL;
}
