<?php namespace Nightsh\DuplicatesExtractor\Parser;

use Nightsh\DuplicatesExtractor\Parser\CSV;
use League\Csv\Reader;

class DuplicateHelper extends CSV {

    protected $input   = '';
    protected $headers = '';

    private $position = 0;
    private $helper;

    public function __construct($file, $helper_column) {
        $this->helper = new \stdClass();

        $this->input = $file;
        $this->csv = Reader::createFromPath($this->input);

        $this->helper->name = $helper_column;
        $this->get_offset();
    }

    private function get_offset() {
        $header = $this->get_header();

        return
        $this->helper->index = array_search(
            $this->helper->name, array_keys($header)
        );
    }

    public function next_id() {
        $this->position++;
        return
        $this->csv
             ->fetchOne($this->position)[$this->helper->index];
    }
}
