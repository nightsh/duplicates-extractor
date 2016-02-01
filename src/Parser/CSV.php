<?php namespace Nightsh\DuplicatesExtractor\Parser;

use League\Csv\Reader;

class CSV {

    protected $input   = '';
    protected $headers = '';

    public function __construct($file) {
        $this->input = $file;
        $this->csv = Reader::createFromPath($this->input);
    }

    public function get_headers() {
        return $this->headers = $this->csv->fetchOne();
    }
}
