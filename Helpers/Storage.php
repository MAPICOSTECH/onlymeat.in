<?php

namespace Helpers;

class Storage {

    public function __construct() {
        $this->storageLocation = GEOMETRY_STORAGE_DIR;
        global $GEOMETRY_DB;
        $this->_db = $GEOMETRY_DB;
    }

    public function createProjectStorage($subscriptionGUID, $groupGUID, $projectGUID) {
        chdir($this->storageLocation);

        //go into subscription folder
        if (!file_exists($subscriptionGUID))
            mkdir($subscriptionGUID);
        chdir($subscriptionGUID);

        //go into group folder
        if (!file_exists($groupGUID)) {
            mkdir($groupGUID);
        }
        chdir($groupGUID);

        //go into project folder
        if (!file_exists($projectGUID))
            mkdir($projectGUID);
        chdir($projectGUID);

        // create folder structure
        // 
        if (!file_exists('project_docs'))
            mkdir('project_docs');
        if (!file_exists('tasks'))
            mkdir('tasks');
        if (!file_exists('files'))
            mkdir('files');
    }

    public function deleteProjectStorage($subscriptionGUID, $groupGUID, $projectGUID) {
        //delete STORAGE / subscriptionGUID / groupGUID / projectGUID folder

        chdir($this->storageLocation);
        if (file_exists($subscriptionGUID))
            chdir($subscriptionGUID);
        if (file_exists($groupGUID))
            chdir($groupGUID);
        if (file_exists($projectGUID))
            unlink($projectGUID);
    }

    public function gotoProjectDirectory($subscriptionGUID, $groupGUID, $projectGUID) {
        chdir($this->storageLocation);
        if (file_exists($subscriptionGUID)) {
            chdir($subscriptionGUID);
            if (file_exists($groupGUID)) {
                chdir($groupGUID);
                if (file_exists($projectGUID)) {
                    chdir($projectGUID);
                    //check project directory structure
                    if (!file_exists('project_docs'))
                        mkdir('project_docs');
                    if (!file_exists('tasks'))
                        mkdir('tasks');
                    if (!file_exists('files'))
                        mkdir('files');
                    return true;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }

    public function gotoTaskDirectory($subscriptionGUID, $groupGUID, $projectGUID, $taskGUID) {
        chdir($this->storageLocation);
        try {

            //go into subscription folder
            if (!file_exists($subscriptionGUID))
                mkdir($subscriptionGUID);
            chdir($subscriptionGUID);

            //go into group folder
            if (!file_exists($groupGUID)) {
                mkdir($groupGUID);
            }
            chdir($groupGUID);

            //go into project folder
            if (!file_exists($projectGUID))
                mkdir($projectGUID);
            chdir($projectGUID);

            //go to tasks folder
            if (!file_exists('tasks'))
                mkdir('tasks');
            chdir('tasks');

            if (!file_exists($taskGUID))
                mkdir($taskGUID);

            chdir($taskGUID);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function gotoMeetingsDirectory($subscriptionGUID, $groupGUID, $projectGUID, $meetingGUID) {
        chdir($this->storageLocation);
        try {

            //go into subscription folder
            if (!file_exists($subscriptionGUID))
                mkdir($subscriptionGUID);
            chdir($subscriptionGUID);

            //go into group folder
            if (!file_exists($groupGUID)) {
                mkdir($groupGUID);
            }
            chdir($groupGUID);

            //go into project folder
            if (!file_exists($projectGUID))
                mkdir($projectGUID);
            chdir($projectGUID);

            //go to tasks folder
            if (!file_exists('meetings'))
                mkdir('meetings');
            chdir('meetings');

            if (!file_exists($meetingGUID))
                mkdir($meetingGUID);

            chdir($meetingGUID);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function gotoDocumentationFolder($subscriptionGUID, $groupGUID, $projectGUID, $folderGUID) {
        chdir($this->storageLocation);
        try {

            //go into subscription folder
            if (!file_exists($subscriptionGUID))
                mkdir($subscriptionGUID);
            chdir($subscriptionGUID);

            //go into group folder
            if (!file_exists($groupGUID)) {
                mkdir($groupGUID);
            }
            chdir($groupGUID);

            //go into project folder
            if (!file_exists($projectGUID))
                mkdir($projectGUID);
            chdir($projectGUID);

            //go to tasks folder
            if (!file_exists('project_docs'))
                mkdir('project_docs');
            chdir('project_docs');

            if (!file_exists($folderGUID))
                mkdir($folderGUID);

            chdir($folderGUID);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function isValidFileExtension($fileName) {
        
    }

    public function getFolderSize($dir) {
        //from http://stackoverflow.com/questions/478121/php-get-directory-size
        $dir = rtrim(str_replace('\\', '/', $dir), '/');

        if (is_dir($dir) === true) {
            $totalSize = 0;
            $os = strtoupper(substr(PHP_OS, 0, 3));
            // If on a Unix Host (Linux, Mac OS)
            if ($os !== 'WIN') {
                $io = popen('/usr/bin/du -sb ' . $dir, 'r');
                if ($io !== false) {
                    $totalSize = intval(fgets($io, 80));
                    pclose($io);
                    return $totalSize;
                }
            }
            // If on a Windows Host (WIN32, WINNT, Windows)
            if ($os === 'WIN' && extension_loaded('com_dotnet')) {
                $obj = new \COM('scripting.filesystemobject');
                if (is_object($obj)) {
                    $ref = $obj->getfolder($dir);
                    $totalSize = $ref->size;
                    $obj = null;
                    return $totalSize;
                }
            }
            // If System calls did't work, use slower PHP 5
            $files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir));
            foreach ($files as $file) {
                $totalSize += $file->getSize();
            }
            return $totalSize;
        } else if (is_file($dir) === true) {
            return filesize($dir);
        }
    }

    public function formatFileSize($filesize) {
        if (is_numeric($filesize)) {
            $decr = 1024;
            $step = 0;
            $prefix = array('Byte', 'KB', 'MB', 'GB', 'TB', 'PB');

            while (($filesize / $decr) > 0.9) {
                $filesize = $filesize / $decr;
                $step++;
            }
            return round($filesize, 2) . ' ' . $prefix[$step];
        } else {

            return '0B';
        }
    }

    public function downloadFile($subscriptionID, $fileGUID) {
        //get path from database
        $sql = "select file_path from storage_files where subscription_id=? and file_guid=?";
        $params = [$subscriptionID, $fileGUID];

        $this->_db->sqlQuery($sql, $params);
        if ($this->_db->result->rows[0]['file_path'] != '') {
            $pathInfo = pathinfo($this->_db->result->rows[0]['file_path']);
            if (in_array($pathInfo['extension'], ['pdf', 'jpg', 'png', 'txt', 'html']))
                $openFile = true;

            if ($_SERVER["HTTPS"] != '') {
                header("Cache-Control: maxage=1");
                header("Pragma: public");
            }

            header('Content-type: application/octet-stream');
            header("Content-Disposition: " . ($openFile ? 'inline' : 'attachment') . "; filename=" . basename($this->_db->result->rows[0]['file_path']) . ";");
            header("Content-Length:" . filesize($this->_db->result->rows[0]['file_path']));
            readfile($this->_db->result->rows[0]['file_path']);
            exit;
        } else {
            header("HTTP/1.0 404 Not Found");
            exit;
        }
    }

    public function uploadFile($fieldName, $newFileName = null, $fileMetaData = null) {
        if ($newFileName == null) {
            $newFileName = basename($_FILES[$fieldName]["name"]);
        }
        if (move_uploaded_file($_FILES[$fieldName]["tmp_name"], $newFileName)) {
            $fileGUID = \Helpers\Utilities::generateGUID();

            $filePath = getcwd() . DIRECTORY_SEPARATOR . $newFileName;
            $sql = "insert into storage_files (subscription_id, file_guid, file_path, file_context, project_guid, task_guid, folder_guid, user_guid, date_logged) "
                    . "values(?, ?, ?, ?, ?, ?, ?, ?, ?) ";
            $params = [$fileMetaData['subscription_id'], $fileGUID, $filePath, $fileMetaData['file_context'], $fileMetaData['project_guid'], $fileMetaData['task_guid'], $fileMetaData['folder_guid'], $fileMetaData['user_guid'], \Helpers\Calendar::getSqlDateTime()];

            return $this->_db->sqlQuery($sql, $params) ? $fileGUID : false;
        }
    }

    public function deleteFile($subscriptionID, $fileGUID) {
        //get path from database
        $sql = "select file_path from storage_files where subscription_id=? and file_guid=?";
        $params = [$subscriptionID, $fileGUID];

        $this->_db->sqlQuery($sql, $params);
        if ($this->_db->result->rows[0]['file_path'] != '') {
            if (unlink($this->_db->result->rows[0]['file_path'])) {
                $sql = "delete from storage_files where subscription_id=? and file_guid=?";
                $params = [$subscriptionID, $fileGUID];
                return $this->_db->sqlQuery($sql, $params);
            }
        } else
            return false;
    }

    public function getTaskFilesList($subscriptionID, $projectGUID, $taskGUID) {
        $sql = "select file_guid, file_path from storage_files where subscription_id=? and project_guid=? and task_guid=?  ";
        $params = [$subscriptionID, $projectGUID, $taskGUID];

        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result;
    }

    public function getMeetingFilesList($subscriptionID, $projectGUID, $meetingGUID) {
        $sql = "select file_guid, file_path from storage_files where subscription_id=? and project_guid=? and meeting_guid=?  ";
        $params = [$subscriptionID, $projectGUID, $meetingGUID];

        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result;
    }

    public function getDocumentationFilesList($subscriptionID, $projectGUID, $folderGUID) {
        $sql = "select file_guid, file_path, date_logged from storage_files where subscription_id=? and project_guid=? and folder_guid=?  ";
        $params = [$subscriptionID, $projectGUID, $folderGUID];

        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result;
    }

    public static function getAvatarPicturePath($subscriptionID, $userGUID) {
        chdir(GEOMETRY_STORAGE_DIR);
        $avatarPicPath = '';
        $avatarPicPath = GEOMETRY_STORAGE_DIR . '/user-avatars/' . $subscriptionID . '/' . $userGUID . 'jpg';
        if (!file_exists($avatarPicPath)) {
            $avatarPicPath = GEOMETRY_STORAGE_DIR . '/user-avatars/default-user.png';
            return GEOMETRY_STORAGE_URL . '/user-avatars/default-user.png';
        } else {
            return GEOMETRY_STORAGE_URL . '/user-avatars/' . $subscriptionID . '/' . $userGUID . 'jpg';
        }
    }

}
