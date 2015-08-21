<?php

class Helpers_Files_Attachment {

    protected $fileName;
    protected $fileContent;

    public function __construct() {
        $this->fileName = 'unnamed_attachment';
        $this->fileContent = '';
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }

    public function setFileContent($fileContent) {
        $this->fileContent = $fileContent;
    }

    public function setContentType($contentType) {
        $this->contentType = $contentType;
    }

    public function readFileContent($fileNameToRead) {
        $this->fileContent = file_get_contents($fileNameToRead);
    }

    public function startDownload() {
        /* if no filename is set, set content type to octet stream */
        if ($this->fileName == 'unnamed_attachment')
            $this->contentType = mime_content_type($this->fileName);
        else
            $this->contentType = 'application/octet-stream';

        /* check if it is SSL connection */
        if ($_SERVER["HTTPS"] != '')
            $this->startSSLDownload();
        else {
            header('Content-type: ' . $this->contentType);
            header("Content-Disposition: attachment; filename=" . $this->fileName . ";");
            echo $this->fileContent;
            exit;
        }
    }

    public function startSSLDownload() {
        header("Cache-Control: maxage=1");
        header("Pragma: public");
        header('Content-type: ' . $this->contentType);
        header("Content-Disposition: attachment; filename=" . $this->fileName . ";");
        echo $this->fileContent;
        exit;
    }

}

