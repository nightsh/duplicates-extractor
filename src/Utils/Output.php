<?php namespace Nightsh\DuplicatesExtractor\Utils;

class Output {

    public function __construct($type, $file = null) {
        $this->type = $type;

        try {
          if ($this->check_file($file) === true) {
              $this->file = $file;
          }
        } catch (Exception $e) {
            echo "Caught exception: ", $e->getMessage(), PHP_EOL;
        }
    }

    public function show($string) {
        switch ($this->type) {
            case 'file':
                file_put_contents($this->file, $string, FILE_APPEND | LOCK_EX);
                break;
            case 'stdout':
                echo $string;
                break;
        }
    }

    private function check_file($file) {
        if (is_file($file)) {
            if (is_writable($file)) {
                return true;
            } else {
                throw new Exception("File is not writable!");
            }
        } else {
            return true;
        }
    }
}
