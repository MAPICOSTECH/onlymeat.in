<?php

namespace Helpers;

class HTMLGenerators {

    public static function alertBox($message) {
        if ($message == '')
            return;
        return ' <div class="alert alert-danger"><p>' . $message . '</p></div>';
    }

    public static function dangerCallout($message = null) {
        if ($message == '')
            return;
        return ' <div class="alert alert-danger"><p>' . $message . '</p></div>';
    }

    public static function infoCallout($message = null) {
        if ($message == '')
            return;
        return ' <div class="alert alert-info"><p>' . $message . '</p></div>';
    }

    public static function warningCallout($message = null) {
        if ($message == '')
            return;
        return ' <div class="alert alert-warning"><p>' . $message . '</p></div>';
    }

    public static function validationSummary($validatorObject) {

        if (!is_object($validatorObject))
            return;

        if ($validatorObject->hasErrors()) {
            $validationErrors = $validatorObject->getAllErrors();

            return ' <div class="alert alert-danger"><p style="text-align:left"> &bull; &nbsp; ' .
                    implode('<br /> &bull; &nbsp; ', $validationErrors) . '</p></div>';
        }
    }

    public static function renderTabsInProjectDetails($projectGUID, $projectMethodology, $activeTab = '', $projectsList = null) {

        if ($projectGUID == '')
            return '';
        ?>
        <ul class="nav nav-tabs">
            <li class="dropdown">
                <a class="dropdown-toggle btn btn-default-hover" data-toggle="dropdown" href="#" aria-expanded="false">
                    <i class="fa fa-external-link-square"></i> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"><strong>My Projects Quick Jump</strong></a></li>                    
                    <li role="presentation" class="divider"></li>                    
                    <?php
                    for ($i = 0; $i < $projectsList->rowCount; $i++) {
                        ?>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/dashboard.php?project=<?php echo $projectsList->rows[$i]['project_guid']; ?>"><?php echo $projectsList->rows[$i]['project_title']; ?></a></li>
                    <?php } ?>
                </ul>
            </li>


            <li class="<?php echo ($activeTab == 'Dashboard') ? 'active' : ''; ?>"><a title="Dashboard" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/dashboard.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-dashboard"></i></a></li>
            <?php
            /* Scrum methodology specific Items */
            if ($projectMethodology == 'scrum') {
                ?>      
            <li class="<?php echo ($activeTab == 'Releases') ? 'active' : ''; ?>"><a title="Releases" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/scrum/releases.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-puzzle-piece"></i></a></li>     
                <li class="<?php echo ($activeTab == 'Sprints') ? 'active' : ''; ?>"><a title="Sprints" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/scrum/sprints.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-clone"></i></a></li> 
                <li class="<?php echo ($activeTab == 'Kanban') ? 'active' : ''; ?>"><a title="Scrum Board" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/scrum/kanban.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-clipboard"></i></a></li>  
                <li class="<?php echo ($activeTab == 'Backlog') ? 'active' : ''; ?>"><a title="Backlog"  href="<?php echo GEOMETRY_BASE_URL; ?>/projects/scrum/backlog-list.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-list-ul"></i></a></li> 
                <li class="<?php echo ($activeTab == 'Tasks') ? 'active' : ''; ?>"><a title="Tasks" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/scrum/tasks.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-tasks"></i></a></li>

                <?php
            } /* Waterfall methodology specific items */ else {
                ?>
                <li class="<?php echo ($activeTab == 'Gantt') ? 'active' : ''; ?>"><a title="Gantt" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/waterfall/gantt.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-sort-amount-asc"></i></a></li>
                <li class="<?php echo ($activeTab == 'Milestones') ? 'active' : ''; ?>"><a title="Milestones" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/waterfall/milestones.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-check-square-o"></i></a></li>
                <li class="<?php echo ($activeTab == 'Tasks') ? 'active' : ''; ?>"><a title="Tasks" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/waterfall/tasks.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-tasks"></i></a></li>


            <?php } ?>

                <li class="<?php echo ($activeTab == 'Meetings') ? 'active' : ''; ?>"><a title="Meetings" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/meetings-list.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-th"></i></a></li>  
                <li class="<?php echo ($activeTab == 'Discussions') ? 'active' : ''; ?>"><a title="Discussions" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/discussions-list.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-commenting-o"></i></a></li>                 

            <li class="<?php echo ($activeTab == 'Tracker') ? 'active' : ''; ?>"><a href="<?php echo GEOMETRY_BASE_URL; ?>/projects/tracker.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-bookmark-o"></i></a></li>
            <li class="<?php echo ($activeTab == 'Members') ? 'active' : ''; ?>"><a title="Members" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/project-members.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-user"></i></a></li>
            <li class="<?php echo ($activeTab == 'Calendar') ? 'active' : ''; ?>"><a title="Project Calendar" href="<?php echo GEOMETRY_BASE_URL; ?>/calendar/index.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-calendar"></i></a></li>
            <li class="<?php echo ($activeTab == 'Notifications') ? 'active' : ''; ?>"><a title="Notifications" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/project-notifications.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-bell"></i></a></li>
            <li class="<?php echo ($activeTab == 'Documentation') ? 'active' : ''; ?>"><a title="Documentation" href="<?php echo GEOMETRY_BASE_URL; ?>/projects/documentation/folders.php?project=<?php echo $projectGUID; ?>"><i class="fa fa-book"></i></a></li>

        </ul>
        <?php
    }

    //ckeditor

    public static function ckeditorBasic($formElementName, $editorHeight = '200', $projectGUID = null) {
        //http://ckeditor.com/latest/samples/plugins/toolbar/toolbar.html 
        return "<script>
		CKEDITOR.replace( \"" . $formElementName . "\" , {
                    height:" . $editorHeight . ",
                        
			// Define the toolbar groups as it is a more accessible solution.
			toolbar: [
                         { name: 'document', groups: [ 'mode' ], items: [ 'Maximize', 'Source'] },
                         { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
                        { name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize','TextColor', 'BGColor'  ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock',  ] },
                        { name: 'insert', items: [  'Image', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },                        
                        { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
			],
			// Remove the redundant buttons from toolbar groups defined above.
			removeButtons: 'Subscript,Superscript,Anchor,Specialchar',
                        filebrowserBrowseUrl : '" . BASE_URL . "/assets/kcfinder/browse.php?opener=ckeditor&type=files&project=" . $projectGUID . "',
                        filebrowserImageBrowseUrl :'" . BASE_URL . "/assets/kcfinder/browse.php?opener=ckeditor&type=images&project=" . $projectGUID . "',
                        filebrowserUploadUrl : '" . BASE_URL . "/assets/kcfinder/upload.php?opener=ckeditor&type=files&project=" . $projectGUID . "',
                        filebrowserImageUploadUrl : '" . BASE_URL . "/assets/kcfinder/upload.php?opener=ckeditor&type=images&project=" . $projectGUID . "',
                 } );
	</script>";
    }

    public static function ckeditorSimple($formElementName, $imagesBrowserPath = null, $imagesUploadPath = null, $editorHeight = '200') {
        //http://ckeditor.com/latest/samples/plugins/toolbar/toolbar.html 
        return "<script>
		CKEDITOR.replace( \"" . $formElementName . "\" , {
                    height:" . $editorHeight . ",

			// Define the toolbar groups as it is a more accessible solution.
			toolbar: [
                         { name: 'document', groups: [ 'mode' ], items: [ 'Maximize', 'Source'] },
                         { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ] },
                        { name: 'styles', items: [ 'FontSize'  ] },
                        { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', '-', 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent',    ] },
                        { name: 'insert', items: [  'Table', 'HorizontalRule', ] },
                        { name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },                        
                        
			],
			// Remove the redundant buttons from toolbar groups defined above.
			removeButtons: 'Subscript,Superscript,Anchor,Specialchar'," .
                ($imagesBrowserPath != '' ? "filebrowserImageBrowseUrl : '" . $imagesBrowserPath . "'," . "\n" : "") .
                ($imagesUploadPath != '' ? "filebrowserImageUploadUrl : '" . $imagesUploadPath . "'," . "\n" : "") .
                " } );
	</script>";
    }

    public static function taskPriorityBadge($priority) {
        switch ($priority) {
            case '1 - Urgent': $string = '<span class = "badge bg-red">Urgent</span>';
                break;
            case '2 - High': $string = '<span class = "badge bg-yellow">High</span>';
                break;
            case '3 - Medium': $string = '<span class = "badge bg-aqua">Medium</span>';
                break;
            case '4 - Low': $string = '<span class = "badge bg-grey">Low</span>';
                break;
        }
        return $string;
    }

    public static function formTextbox($labelText, $fieldName, $defaultValue = '', $placeholderValue = '') {
        if ($labelText == null) {
            $string = '<div class="form-group row">
                   <p class="col-md-12">
                        <input type="text" class="form-control" placeholder="' . $placeholderValue . '" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $defaultValue . '" /></p>
                </div>';
        } else {
            $string = '<div class="form-group row">
                    <p class="col-md-3"><label for="' . $fieldName . '">' . $labelText . '</label></p>
                    <p class="col-md-8">
                        <input type="text" class="form-control" placeholder="' . $placeholderValue . '" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $defaultValue . '" /></p>
                </div>';
        }
        return $string;
    }

    public static function formSelect($labelText, $fieldName, $keyIndexedValuesArray = '', $selectedValue = '') {
        if ($labelText != '')
            $string = '<div class="form-group row">
                    <div class="col-md-3"><label for="' . $fieldName . '">' . $labelText . '</label></div>
                    <div class="col-md-8">';
        else
            $string = '<div class="form-group">';

        $string.=' <select class="form-control" id="' . $fieldName . '" name="' . $fieldName . '">';

        foreach ($keyIndexedValuesArray as $key => $value) {
            if (is_array($value)) {
                $string.='<optgroup label="' . $key . '">' . "\n";
                foreach ($value as $optionKey => $optionValue) {
                    $string.= '<option value="' . $optionKey . '">' . $optionKey . '</option>' . "\n";
                }
                $string.='</optgroup>' . "\n";
            } else {
                $string.= '<option value="' . $key . '">' . $value . '</option>' . "\n";
            }
        }
        $string.='</select>';
        $string.=($labelText != '' ? '</div>' : '') . '</div>';
        return $string;
    }

    public static function formTextarea($labelText, $fieldName, $defaultValue = '', $placeholderValue = '', $rows = 3) {
        if ($labelText != '') {
            $string = '<div class="form-group row">
                        <div class="col-md-3"><label for="' . $fieldName . '">' . $labelText . '</label></div>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="' . $rows . '" id="' . $fieldName . '" name="' . $fieldName . '" placeholder="' . $placeholderValue . '">' . $defaultValue . '</textarea></div>
                    </div>';
        } else {
            $string = '<div class="form-group row">
                       <div class="col-md-12">
                            <textarea class="form-control" rows="' . $rows . '" id="' . $fieldName . '" name="' . $fieldName . '" placeholder="' . $placeholderValue . '">' . $defaultValue . '</textarea></div>
                    </div>';
        }
        return $string;
    }

    public static function formDateTextbox($labelText, $fieldName, $defaultValue = '') {
        if ($labelText != '')
            $string = '<div class="form-group row">
                <div class="col-md-3 col-sm-3"><label for="' . $fieldName . '">' . $labelText . '</label></div>
                <div class="col-md-8">
                    <div class="input-group ">
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                        <input type="text" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $defaultValue . '" placeholder="dd-MMM-yyyy">
                    </div>
                </div>
            </div>';
        else
            $string = '<div class="input-group">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $defaultValue . '" placeholder="dd-MMM-yyyy">
                    </div>';
        return $string;
    }

    public static function formTimeTextbox($labelText = '', $fieldName = '', $defaultValue = '') {
        if ($labelText != '') {
            $string = '<div class="form-group row">
                    <p class="col-md-3"><label for="' . $fieldName . '">' . $labelText . '</label></p>
                    <p class="col-md-8">
                        <input type="text" class="form-control" placeholder="09:30 AM" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $defaultValue . '" /></p>
                </div>';
        } else {
            $string = '<div class="form-group">
                    <div class="input-group bootstrap-timepicker">
                        <input type="text" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $defaultValue . '" placeholder="dd-MMM-yyyy" >
                        <div class="input-group-addon">
                            <i class="fa fa-clock-o"></i>
                        </div>
                    </div>
                </div>';
        }
        return $string;
    }

    public static function formSubmit($textOnButton, $fieldName) {
        $string = '<div class="form-group row">
                    <div class="col-md-3"> </div>
                    <div class="col-md-8">
                        <input type="submit" class="form-control" id="' . $fieldName . '" name="' . $fieldName . '" value="' . $textOnButton . '" /></div>
                </div>';
        return $string;
    }

    public static function fileLink($filePath, $fileLink, $deleteLink = null, $returnAsBoxLink = false, $lastModifiedDateTime = null) {
        //get the extension
        $pathInfo = pathinfo($filePath);
        switch (strtolower($pathInfo['extension'])) {
            case 'pdf': $iconName = 'fa-file-pdf-o';
                break;
            case 'docx': case 'doc':case 'rtf': $iconName = 'fa-file-word-o';
                break;
            case 'mp4':case 'mpeg':case 'mov': $iconName = 'fa-file-video-o';
                break;
            case 'txt':case 'log': $iconName = 'fa-file-text-o';
                break;
            case 'pptx':case 'ppsx': case 'ppt':case 'pps': $iconName = 'fa-file-powerpoint-o';
                break;
            case 'pdf': $iconName = 'fa-file-pdf-o';
                break;
            case 'jpg':case 'jpeg':case 'png':case 'gif':case 'bmp': $iconName = 'fa-file-image-o';
                break;
            case 'xlsx': case 'xls': $iconName = 'fa-file-excel-o';
                break;
            case 'mp3': case 'ogg': $iconName = 'fa-file-audio-o';
                break;
            case 'zip': $iconName = 'fa-file-archive-o';
                break;
            case null:$iconName = 'fa-folder-o';
                break;
            default: $iconName = 'fa-file-o';
                break;
        }
        if ($returnAsBoxLink) {
            ?>

                            <div class="file-box">
            <div class="file">
                <a href="<?php echo $fileLink; ?>">
                    <div class="icon">
                        <i class="fa <?php echo $iconName; ?>"></i>
                    </div>
                    <div class="file-name">
                        <?php echo substr_replace($pathInfo['basename'], '<br />', 25, 0); ?>
                        <br/>
                        <small>Last updated: <?php echo \Helpers\Calendar::formatDateTime($lastModifiedDateTime, 'd-M-Y H:i'); ?></small>
                        <?php if ($deleteLink != null) { ?>
                        <a href="<?php echo $deleteLink; ?>" class="btn btn-danger"><i class="fa fa-trash"></i></a>
                        <?php } ?>
                    </div>
                </a>
            </div> 
            </div>   
            <?php
        } else {
            return '<a href="' . $fileLink . '"><i class="fa ' . $iconName . '"></i> &nbsp; ' . $pathInfo['basename'] . '</a>';
        }
    }

}
