<?php
class hashFile {
    public $hashes = array();
    public $base = '';
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
}