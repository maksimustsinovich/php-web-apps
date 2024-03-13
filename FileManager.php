<?php

class FileManager {
    private $directory;

    public function __construct($directory) {
        $this->directory = $directory;
    }

    public function uploadFile($file) {
        $targetFile = $this->directory . basename($file["name"]);
        return move_uploaded_file($file["tmp_name"], $targetFile);
    }

    public function changeDirectory($subDirectory) {
        $this->directory .= $subDirectory . '\\';
    }

    public function listFiles() {
        return array_diff(scandir($this->directory), array('..', '.'));
    }

    public function deleteFile($filename) {
        $file = $this->directory . $filename;
        if (file_exists($file)) {
            return unlink($file);
        }
        return false;
    }

    public function getDirectory()
    {
        return $this->directory;
    }
}
