<?php

namespace Helpers\Db;
class Datasource extends Result {

    public $rows, $fields, $indexRows, $rowCount, $colCount;
    public $id;

    public function __construct($id = false) {
        if ($id)
            $this->id = $id;
        $this->rows = array();
        $this->fields = array();
    }

    public function prepare() {
        $this->rowCount = count($this->rows);
        $this->colCount = count($this->fields);
		
		if(!isset($this->indexRows))
		{
			$this->indexRows=1;
		}
    }

    public function addRow($indexedArrayData) {
        if (is_array($indexedArrayData)) {
            $this->rows[] = $indexedArrayData;
            $this->fields = array_keys($indexedArrayData);
        }
    }

}
