<?php

class Helpers_Files_CSVReader {

    private $_fp;
    public $rows, $rowCount, $colCount;

    public function read($fileName, $firstRowHasHeadings = false) {
        if (!is_readable($fileName)) {
            $this->error = 'The file - ' . $fileName . ' - is not readable.';
            return;
        }

        $this->_fp = fopen($fileName, 'r');
        if ($firstRowHasHeadings) {
            $this->indexRows = true;
            $this->fields = fgetcsv($this->_fp);
            $this->colCount = count($this->fields);
        }

        while (!feof($this->_fp)) {
            $row = fgetcsv($this->_fp);
            $this->rows[] = $row;
            if ($this->colCount < count($row))
                $this->colCount = count($row);
        }
        fclose($this->_fp);

        $this->rowCount = count($this->rows);
    }

}

?>