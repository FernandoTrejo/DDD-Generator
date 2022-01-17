<?php

class FileGenerator{

    public static function create($name, $content, $extension = ".php"){
        $file = fopen($name . $extension, "w");
        fwrite($file, $content);
        fclose($file);
    }
}