<?php

class Helpers_Files_DirectoryBrowser {
    /* paths */

    protected $path;
    public $pathParts;
    protected $startPath;
    public $dirs, $files, $source;
    protected $createSource;

    public function __construct($startPath = '.') {
        $this->startPath = $startPath;
        $this->path = $startPath;
    }

    public function resetPath() {
        $this->path = $this->startPath;
        chdir($this->path);
    }

    //path operations
    public function setPath($path, $changeDir = false) {

        if (!$path)
            return false;
        if ($changeDir) {
            //if (file_exists($path))
            $path = str_replace(array('C:', 'D:', 'E:'), '', $path);
            chdir($path);
        }
        $this->path = $path;
        if (substr($this->path, strlen($this->path) - 2, 1) != '/')
            $this->path.='/';
    }

    public function getPath() {
        return $this->path;
    }

    //dir operaations
    public function mkdir($dirName) { //create a directory
        $dirName = trim($this->clean($dirName));

        if (!file_exists($dirName) && $dirName != '')
            return mkdir($dirName);
    }

    public function clean($string) {
        $string = str_replace(':', '', $string);
        $string = str_replace('..', '', $string);
        $string = str_replace('/', '', $string);
        return $string;
    }

    public function chdir($path) { //change to specified dir
        @chdir($path);
        $this->setPath(getcwd());
    }

    public function pwd() { //know the present working directory
        return getcwd();
    }

    public function exists($object) {
        return @file_exists($object);
    }

    public function readDir($trimContents = true) {
        $this->dirs = array();
        $this->files = array();
        if ($trimContents)
            $this->trimContents = true;
        if (!$dp = opendir(".")) {
            $this->error = 'Could not open directory for reading';
            return false;
        }
        //read contents
        while ($file = readdir($dp)) {
            $dirNotEmpty = true;
            if (is_dir($file)) {
                $dirs['Name'] = $file;
                $dirs['Size'] = filesize($file);
                $dirs['Perms'] = substr(sprintf('%o', fileperms($file)), -4);
                $dirs['Modified_Time'] = date("Y-m-d h:i:s", filemtime($file));
                $dirs['Type'] = 'DIR';
                $this->dirs[] = $dirs;
            }
            if (is_file($file)) {
                $files['Name'] = $file;
                $files['Size'] = filesize($file);
                $files['Perms'] = substr(sprintf('%o', fileperms($file)), -4);
                $files['Modified_Time'] = date("Y-m-d h:i:s", filemtime($file));
                $files['Type'] = 'FILE';
                $this->files[] = $files;
            }
        }
        if ($dirNotEmpty) {
            if ($trimContents) { //remove . and ..
                array_shift($this->dirs);
                array_shift($this->dirs);
            }
            @sort($this->dirs);
            @sort($this->dirs); //sort it
            //if create a source
            if ($this->createSource) {
                $this->source = '';
                $this->source = new Helpers_Files_FileSystemSource;
                $this->source->rows = array_merge($this->dirs, $this->files);
                $this->source->rowCount = count($this->source->rows);
                $this->source->fields = array('Name', 'Size', 'Perms', 'Modified_Time', 'Type');
                $this->source->indexRows = true;
                $this->source->colCount = count($this->source->fields);
                $this->dirs = array();
                $this->files = array();
            }
        }
    }

    public function upload(&$postField, $newName = false) {

        $fileName = $newName ? $newName : $postField['name'];
        if (is_uploaded_file($postField['tmp_name']))
            return copy($postField['tmp_name'], $fileName);
    }

    public function reset() {
        $this->dirs = array();
        $this->files = array();
        $this->path = '.';
        $this->source = '';
    }

    public function createFile($name, $content) {
        $fp = fopen($name, 'w');
        $status = fwrite($fp, $content);
        fclose($fp);
        return $status;
    }

    public function delete($fileName) {
        return @unlink($fileName);
    }

    public function rmdir($dirName) {
        return @rmdir($dirName);
    }

    public static function getDirectorySize($path) {

        $totalsize = 0;
        $totalcount = 0;
        $dircount = 0;
        if ($handle = opendir($path)) {
            while (false !== ($file = readdir($handle))) {
                $nextpath = $path . '/' . $file;
                if ($file != '.' && $file != '..' && !is_link($nextpath) && $file != 'index.php') {
                    if (is_dir($nextpath)) {
                        $dircount++;
                        $result = self::getDirectorySize($nextpath);
                        $totalsize += $result['size'];
                        $totalcount += $result['count'];
                        $dircount += $result['dircount'];
                    } elseif (is_file($nextpath)) {
                        $totalsize += filesize($nextpath);
                        $totalcount++;
                    }
                }
            }
        }
        closedir($handle);
        $total['size'] = $totalsize;
        $total['count'] = $totalcount;
        $total['dircount'] = $dircount;
        return $total;
    }

    public static function getMimeType($fileName) {
        $fileParts = explode('.', basename($fileName));
        $extension = strtolower(trim($fileParts[count($fileParts) - 1]));
        switch ($extension) {
            case 'zip':
                $mimeType = 'application/x-zip-compressed';
                break;
            case '7z':
                $mimeType = 'application/7z';
                break;
            default:
                $mimeType = 'application/octet-stream';
                break;
        }
        return $mimeType;
    }

}

class Helpers_Files_FileSystemSource {
    
}
