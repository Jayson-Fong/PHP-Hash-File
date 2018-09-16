<?php
class hashFile {
    private $hashes = array();
    private $compare = array();
    private $base = '';
    public function __construct($base = null) {
        if (!is_null($base)) $this->base = $base;
    }
    public function hashDirectoryFiles($directory) {
        if (!is_dir($directory)) return false;
        return $this->processDirectory($directory);
    }
    private function processDirectory($directory) {
        $dir = scandir($directory);
        foreach ($dir as $file) {
            if ($file != '.' && $file != '..') {
                if (is_dir($directory . '/' . $file)) {
                    $this->hashDirectoryFiles($directory . '/' . $file);
                } else {
                    $this->hashFile($directory . '/' . $file);
                }
            }
        }
    }
    public function hashFile($file) {
        if (!is_file($file)) return false;
        $this->hashes[str_replace($this->base, '', $file)] = md5_file($file);
    }
    public function getHashes() {
        return $this->hashes;
    }
    public function compareFile($fileFull, $compare = array()) {
        if (is_file($fileFull)) {
            $file = str_replace($this->base, '', $fileFull);
            if (isset($compare[$file]) && array_key_exists($file, $compare) && md5_file($fileFull) == $compare[$file]) {
                $this->compare[$file] = 1;
            } else {
                $this->compare[$file] = 0;
            }
        }
    }
    public function compareDirectory($directory, $compare = array()) {
        $dir = scandir($directory);
        foreach ($dir as $file) {
            if ($file != '.' && $file != '..') {
                if (is_dir($directory . '/' . $file)) {
                    $this->compareDirectory($directory . '/' . $file, $compare);
                } else {
                    $this->compareFile($directory . '/' . $file, $compare);
                }
            }
        }
    }
    public function getCompareData() {
        return $this->compare;
    }
}
