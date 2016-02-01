<?php namespace Nightsh\DuplicatesExtractor\Utils;

class Help {

    public function __construct() {
        $this->show_help();
    }

    protected function show_help() {
        echo <<<HELP
    -h                show this help
    -q                quiet mode
    -i <input_file>   (required) input file path
    -o <output_file>  (optional) output file path; output to STDOUT otherwise
HELP;
        echo PHP_EOL;
    }
}
