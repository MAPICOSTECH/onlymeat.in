<?php

namespace Helpers;

class Documentation {

    public function __construct() {
        $this->storage = new \Helpers\Storage();
        $this->storageLocation = GEOMETRY_STORAGE_DIR;
        global $GEOMETRY_DB;
        $this->_db = $GEOMETRY_DB;
    }

    /* folder methods */

    public function createFolder($subscriptionID, $projectGUID, $folderGUID, $folderDetails) {
        $sql = " insert into documentation (subscription_id, parent_node_guid, node_guid, project_guid, node_type, node_title, 
        		user_guid_logged, last_updated, creation_date) 
        		values(?, ?, ?, ?, ?, ?, ?, ?, ?) ";
        $params = [$subscriptionID, null, $folderGUID, $folderDetails['project_guid'], 'folder', $folderDetails['folder_name'],
            $folderDetails['user_guid'],
            \Helpers\Calendar::getSqlDateTime(), \Helpers\Calendar::getSqlDateTime()];
        return $this->_db->sqlQuery($sql, $params);
    }

    public function renameFolder($subscriptionID, $projectGUID, $folderGUID, $folderDetails) {
        $sql = " update documentation set node_title=?, last_updated=? 
            where subscription_id=? and  node_guid=? and 
            project_guid=? and node_type='folder' and user_guid_logged=?";
        $params = [$folderDetails['folder_name'], \Helpers\Calendar::getSqlDateTime(), $subscriptionID, $folderGUID, $folderDetails['project_guid'], $folderDetails['user_guid']];

        return $this->_db->sqlQuery($sql, $params);
    }

    public function deleteFolder($folderGUID, $folderName) {
        
    }

    public function getFoldersList($subscriptionID, $projectGUID, $returnLessData = true) {
        if ($returnLessData)
            $sql = "select parent_node_guid, node_guid, node_title ";
        else
            $sql = "select parent_node_guid, node_guid, node_title, user_guid_logged, last_updated, creation_date ";

        $sql.= " from documentation "
                . " where node_type='folder' and subscription_id=? and project_guid=? order by node_title";
        $params = [$subscriptionID, $projectGUID];
        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result;
    }

    public function getFolderDetails($subscriptionID, $projectGUID, $folderGUID) {
        $sql = "select parent_node_guid, node_guid, node_title, user_guid_logged, last_updated, creation_date "
                . "from documentation "
                . " where node_type='folder' and subscription_id=? and project_guid=? and node_guid=? ";
        $params = [$subscriptionID, $projectGUID, $folderGUID];
        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result->rows[0];
    }

    /* document methods */

    public function createDocument($subscriptionID, $projectGUID, $documentGUID, $documentDetails) {
        $sql = " insert into documentation (subscription_id, parent_node_guid, node_guid, project_guid, node_type, node_title, 
        		user_guid_logged, last_updated, creation_date) 
        		values(?, ?, ?, ?, ?, ?, ?, ?, ?) ";
        $params = [$subscriptionID, $documentDetails['folder_guid'], $documentGUID, $documentDetails['project_guid'], 'document', $documentDetails['document_name'], $documentDetails['user_guid'],
            \Helpers\Calendar::getSqlDateTime(), \Helpers\Calendar::getSqlDateTime()];
        return $this->_db->sqlQuery($sql, $params);
    }

    public function renameDocument($subscriptionID, $projectGUID, $documentGUID, $documentDetails) {
        $sql = " update documentation set node_title=?, last_updated=? 
            where subscription_id=? and  node_guid=? and 
            project_guid=? and node_type='document' and user_guid_logged=?";
        $params = [$documentDetails['document_name'], \Helpers\Calendar::getSqlDateTime(), $subscriptionID, $documentGUID, $documentDetails['project_guid'], $documentDetails['user_guid']];

        return $this->_db->sqlQuery($sql, $params);
    }

    public function deleteDocument($documentGUID) {
        
    }

    public function getDocumentsList($subscriptionID, $projectGUID, $folderGUID, $returnLessData = true) {
        if ($returnLessData)
            $sql = "select parent_node_guid, node_guid, node_title ";
        else
            $sql = "select parent_node_guid, node_guid, node_title, user_guid_logged, last_updated, creation_date ";

        $sql.= " from documentation "
                . " where node_type='document' and subscription_id=? and project_guid=? and parent_node_guid=? order by node_title";
        $params = [$subscriptionID, $projectGUID, $folderGUID];
        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result;
    }

    public function checkDocumentAccess($subscriptionID, $projectGUID, $documentGUID, $userGUID) {
        $sql = "select count(*) `count` from documentation where subscription_id=? and project_guid=? and node_guid=? and node_type='document' ";
        $this->_db->sqlQuery($sql, [$subscriptionID, $projectGUID, $documentGUID]);
        if ($this->_db->result->rows[0]['count'] > 0)
            return true;
        else
            return false;
    }

    public function getDocumentDetails($subscriptionID, $projectGUID, $documentGUID) {
        $sql = "select parent_node_guid, node_guid, node_title, user_guid_logged, last_updated, creation_date "
                . "from documentation "
                . " where node_type='document' and subscription_id=? and project_guid=? and node_guid=? ";
        $params = [$subscriptionID, $projectGUID, $documentGUID];
        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result->rows[0];
    }

    /* page methods */

    public function createPage($subscriptionID, $projectGUID, $pageGUID, $pageDetails) {
        $sql = " insert into documentation (subscription_id, parent_node_guid, node_guid, project_guid, node_type, node_title, content,
        		user_guid_logged, last_updated, creation_date) 
        		values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?) ";
        $params = [$subscriptionID, $pageDetails['document_guid'], $pageGUID, $pageDetails['project_guid'], 'page', $pageDetails['page_title'], $pageDetails['page_content'], $pageDetails['user_guid'],
            \Helpers\Calendar::getSqlDateTime(), \Helpers\Calendar::getSqlDateTime()];
        return $this->_db->sqlQuery($sql, $params);
    }

    public function updatePage($subscriptionID, $projectGUID, $pageGUID, $pageDetails) {
        $sql = " update documentation set node_title=?, content=?, last_updated=? 
            where subscription_id=? and  node_guid=? and parent_node_guid=? and project_guid=? and node_type='page' and user_guid_logged=?";
        $params = [$pageDetails['page_title'], $pageDetails['page_content'], \Helpers\Calendar::getSqlDateTime(),
            $subscriptionID,  $pageGUID,$pageDetails['document_guid'], $projectGUID, $pageDetails['user_guid']];
        return $this->_db->sqlQuery($sql, $params);
    }

    public function deletePage($pageGUID) {
        
    }

    public function getPageDetails($subscriptionID, $projectGUID, $documentGUID, $pageGUID) {
        $sql = "select parent_node_guid, node_guid, node_title, content, user_guid_logged, last_updated, creation_date "
                . "from documentation "
                . " where node_type='page' and subscription_id=? and project_guid=? and parent_node_guid=? and node_guid=?";
        $params = [$subscriptionID, $projectGUID, $documentGUID, $pageGUID];
        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result->rows[0];
    }

    public function getPagesList($subscriptionID, $projectGUID, $documentGUID, $returnLessData = false) {
        if ($returnLessData)
            $sql = "select parent_node_guid, node_guid, node_title ";
        else
            $sql = "select parent_node_guid, node_guid, node_title, user_guid_logged, last_updated, creation_date ";

        $sql.= " from documentation "
                . " where node_type='page' and subscription_id=? and project_guid=? and parent_node_guid=? order by node_title";
        $params = [$subscriptionID, $projectGUID, $documentGUID];
        $this->_db->sqlQuery($sql, $params);
        return $this->_db->result;
    }

}
