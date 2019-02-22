<?php
// *************************************************************************
// * simpilotgroup Charter Center module for phpVMS va system              *
// * Copyright (c) David Clark (simpilotgroup) All Rights Reserved         *
// * Release Date: December 3rd 2011                                       *
// * Version 1.0                                                           *
// * Email: admin@simpilotgroup.com                                        *
// * Website: http://www.simpilotgroup.com                                 *
// *************************************************************************
// * This software is furnished under a license and may be used and copied *
// * only  in  accordance  with  the  terms  of such  license and with the *
// * inclusion of the above copyright notice.  This software  or any other *
// * copies thereof may not be provided or otherwise made available to any *
// * other person.  No title to and  ownership of the  software is  hereby *
// * transferred.                                                          *
// *************************************************************************
// * You may not reverse  engineer, decompile, defeat  license  encryption *
// * mechanisms, or  disassemble this software product or software product *
// * license. In such event,  licensee  agrees to return license to        *
// * licensor and/or destroy  all copies of software  upon termination of  *
// * the license.                                                          *
// *************************************************************************

    error_reporting(0);

    if(!file_exists('../core/codon.config.php'))
            {
                echo '<hr /><br /><img src="./simpilotgroup.png" alt="simpilotgroup.com" /><br /><br />';
                echo '<hr /><h4><font color="#FF0000">It Does Not Appear That The Charter Center Installer Has Been Placed In The phpVMS Application Root</font></h4>';
                echo '<h4><font color="#FF0000">The Charter Center Install Folder Must Be Placed In The Same Folder As Your /admin, /core, and /lib folders.</font></h4>';
                echo '<a href="./index.php">Check For Proper Location Again<br /><br /></a><hr />';
            }
    else
    {
    include_once '../core/codon.config.php';

    //check login and admin status

    if(Auth::LoggedIn())
            {
                    if(PilotGroups::group_has_perm(Auth::$usergroups, ACCESS_ADMIN))
                    {
                        echo '<hr /><br /><img src="./simpilotgroup.png" alt="simpilotgroup.com" /><br /><br />';
                        echo '<hr /><h4>Charter Center Installer For '.SITE_NAME.'</h4>';
                        echo '<hr /><br /><a href="./index.php">Charter Center Installer Home</a><br /><br /><hr />';
                    }
             else
                    {
                        header('Location: '.url('/'));
                    }
            }
            else
            {header('Location: '.url('/'));}

    //controller

    if ($_GET['func'] == install)
        {
            set_time_limit(0);

            echo 'Installing Charter Center...<hr />';
            
            //create folders and move files
            echo '<h4>Installing Charter Center Module Files</h4>';

            flush();

            if(!file_exists('../core/modules/CharterCenter'))
            {
            if(mkdir('../core/modules/CharterCenter'))
            {echo 'Charter Center Module Folder Created<br /><br />';}
            }
            else
            {echo 'Charter Center Module Folder Already Exists<br /><br />';}

            flush();

            if(!file_exists('../admin/modules/CharterCenter'))
            {
            if(mkdir('../admin/modules/CharterCenter'))
            {echo 'Charter Center Administrator Module Folder Created<br /><br />';}
            }
            else
            {echo 'Charter Center Administrator Module Folder Already Exists<br /><br />';}

            flush();

            if(!file_exists('../core/modules/CharterCenter/CharterCenter.php'))
            {
            if(copy('./core/modules/CharterCenter/CharterCenter.php','../core/modules/CharterCenter/CharterCenter.php'))
                {echo 'Charter Center Controller Installed<br /><br />';}
                else
                {echo 'Error Installing Charter Center Controller<br /><br />';}
            }
            else
            {echo 'Charter Center Controller Already Exists<br /><br />';}

            flush();

            if(!file_exists('../core/common/CharterCenterData.class.php'))
            {
            if(copy('./core/common/CharterCenterData.class.php','../core/common/CharterCenterData.class.php'))
                {
                    echo 'Charter Center Data Class Installed<br /><br />';
                }
            else
                {echo 'Error Installing Charter Center Data Class<br /><br />';}
            }
            else
            {echo 'Charter Center Data Class Already Exists<br /><br />';}

            flush();
            
            if(!file_exists('../core/common/CharterPagination.class.php'))
            {
            if(copy('./core/common/CharterPagination.class.php','../core/common/CharterPagination.class.php'))
                {
                    echo 'Charter Center Pagination Installed<br /><br />';
                }
            else
                {echo 'Error Installing Charter Pagination Class<br /><br />';}
            }
            else
            {echo 'Charter Center Data Class Already Exists<br /><br />';}

            flush();

            if(!file_exists('../admin/modules/CharterCenter/CharterCenter.php'))
            {
            if(copy('./admin/modules/CharterCenter/CharterCenter.php','../admin/modules/CharterCenter/CharterCenter.php'))
                {echo 'Charter Center Administration Controller Installed<br /><br />';}
            else
                {echo 'Error Installing Charter Center Admin Controller<br /><br />';}
            }
            else
            {echo 'Charter Center Admin Controller Already Exists<br /><br />';}

            flush();

            //html templates
            if(!file_exists('../core/templates/CharterCenter'))
            {
                @mkdir('../core/templates/CharterCenter');

                $files = opendir('./core/templates/CharterCenter');
                    while (false !== ($file = readdir($files))) {
                        if($file == '.' OR $file == '..' OR $file == 'email' OR $file == 'images')
                        {continue;}
                        echo 'Installing --> '.$file.'<br />';
                            copy('./core/templates/CharterCenter/'.$file,'../core/templates/CharterCenter/'.$file);
                            flush();
                    }
                closedir($files);

                echo 'Charter Center Templates Installed<br /><br />';
            }
            else
            {echo 'Charter Center Templates Already Exist<br /><br />';}

            flush();

            //admin templates
            if(!file_exists('../admin/modules/templates/CharterCenter'))
            {
                @mkdir('../admin/templates/CharterCenter');

                $files = opendir('./admin/templates/CharterCenter');
                    while (false !== ($file = readdir($files))) {
                        if($file == '.' OR $file == '..')
                        {continue;}
                        echo 'Installing --> '.$file.'<br />';
                        copy('./admin/templates/CharterCenter/'.$file,'../admin/templates/CharterCenter/'.$file);
                        flush();
                    }
                closedir($files);

                echo 'Charter Center Administration Templates Installed<br /><br />';
            }
            else
            {echo 'Charter Center Admin Templates Already Exist<br /><br />';}

            echo '<h4>Success: Charter Center Files Installed</h4><hr />';

            $servername = $_SERVER['SERVER_NAME'];
            $serveraddress = $_SERVER['SERVER_ADDR'];
            $host = $_SERVER['HTTP_HOST'];
            $root = $_SERVER['PHP_SELF'];
            $user = $_SERVER['REMOTE_ADDR'];
            $email = 'admin@simpilotgroup.com';
            $sub = 'Charter Center (ver 1.0) Installation';
            $message = 'The simpilotgroup Charter Center ver 1.0 Module has been installed at '.
                        SITE_NAME.'.<br />Server Name: '.$servername.'
                        <br />Server IP Address: '.$serveraddress.'<br />Host: '.$host.'
                        <br />Document Root: '.$root.'<br />User ip:'.$user;
            Util::SendEmail($email, $sub, $message);            
            
            echo '<b>SQL INSTALL WILL APPEAR IN A POPUP!</b>';

            ?>
            <form method="link" action=""
                  onClick="parent.window.open('<?php echo SITE_URL.'/CharterInstall'; ?>', '_self'), window.open('<?php echo SITE_URL.'/CharterInstall/bigdump.php'; ?>', 'PopupPage', 'height=600,width=800,scrollbars=yes,resizable=yes'); return false" target="_blank">
            <input type="submit" value="Start SQL Install" />
            </form>
            <?php
                 flush();
            }
        elseif($_GET['func'] == uninstall)
            {
            set_time_limit(0);

            echo '<h4>Uninstalling Charter Center 1.0</h4>';
            
            if(@unlink('../core/common/CharterCenterData.class.php')){echo 'CharterCenterData.class.php removed<br />';}else{echo 'Could Not Remove CharterCenterData.class.php - File Not Found.<br />';}
            if(@unlink('../core/common/CharterPagination.class.php')){echo 'CharterPagination.class.php removed<br />';}else{echo 'Could Not Remove CharterPagination.class.php - File Not Found.<br />';}
            if(@unlink('../core/modules/CharterCenter/CharterCenter.php')){echo 'CharterCenter.php removed<br />';}else{echo 'Could Not Remove CharterCenter.php - File Not Found.<br />';}
            if(@unlink('../admin/modules/CharterCenter/CharterCenter.php')){echo 'CharterCenter.php removed<br />';}else{echo 'Could Not Remove CharterCenter.php - File Not Found.<br />';}
            if(@rmdir('../core/modules/CharterCenter')){echo 'Charter Center folder removed<br />';}else{echo 'Could Not Remove Charter Center Folder - Folder Not Found.<br />';}
            if(@rmdir('../admin/modules/CharterCenter')){echo 'CharterCenter folder removed<br />';}else{echo 'Could Not Remove CharterCenter Folder - Folder Not Found.<br />';}

            $query = "DESC ".TABLE_PREFIX."charter_added_by";
            $tablecheck = DB::get_results($query);
            if($tablecheck)
            {
                $query2 = "DROP TABLE ".TABLE_PREFIX."charter_added_by"; DB::query($query2);
                echo TABLE_PREFIX.'charter_added_by SQL Table Removed<br />';
            }
            else
            {echo 'Could Not Remove '.TABLE_PREFIX.'charter_added_by SQL Table - Table Does Not Exist<br />';}
            
            $query = "DESC ".TABLE_PREFIX."charter_airports";
            $tablecheck = DB::get_results($query);
            if($tablecheck)
            {
                $query2 = "DROP TABLE ".TABLE_PREFIX."charter_airports"; DB::query($query2);
                echo TABLE_PREFIX.'charter_airports SQL Table Removed<br />';
            }
            else
            {echo 'Could Not Remove '.TABLE_PREFIX.'charter_airports SQL Table - Table Does Not Exist<br />';}
            
            $query = "DESC ".TABLE_PREFIX."charter_countries";
            $tablecheck = DB::get_results($query);
            if($tablecheck)
            {
                $query2 = "DROP TABLE ".TABLE_PREFIX."charter_countries"; DB::query($query2);
                echo TABLE_PREFIX.'charter_countries SQL Table Removed<br />';
            }
            else
            {echo 'Could Not Remove '.TABLE_PREFIX.'charter_countries SQL Table - Table Does Not Exist<br />';}
            
            //remove html templates
            $files = opendir('../core/templates/CharterCenter');
                    while (false !== ($file = readdir($files))) {
                        if($file == '.' OR $file == '..')
                        {continue;}
                        echo 'Removing --> '.$file.'<br />';
                        @unlink('../core/templates/CharterCenter/'.$file);
                        flush();
                    }
                closedir($files);
            @rmdir('../core/templates/CharterCenter');
                echo 'Charter Center Templates Removed<br />';

            //remove admin templates
            $files = opendir('../admin/templates/CharterCenter');
                    while (false !== ($file = readdir($files))) {
                        if($file == '.' OR $file == '..')
                        {continue;}
                        echo 'Removing --> '.$file.'<br />';
                        @unlink('../admin/templates/CharterCenter/'.$file);
                        flush();
                    }
                closedir($files);
            @rmdir('../admin/templates/CharterCenter');
                echo 'Charter Center Admin Templates Removed<br />';
        }
    else
        {
            echo '<h4>Installation:</h4>';

            if(file_exists('../core/common/CharterCenterData.class.php'))
                {
                    echo '<h4><font color="#32CD32">The Charter Center Appears To Already Be Installed</font></h4>';
                    echo '<h4><font color="#FF0000">Remember To Delete The Charter Center Installer Folder From Your Site When The Install Is Complete!</font></h4>';
                    echo '<a href="'.SITE_URL.'/CharterInstall/index.php?func=uninstall">Uninstall Charter Center (This Will Remove All Files AND Databases For The Charter Center!)<br /><br /></a><hr />';
                }
                else
                {
                    echo '<h4><font color="#32CD32">The Charter Center Installer Is Placed Correctly In The phpVMS Application Root</font></h4>';
                    echo '<a href="'.SITE_URL.'/CharterInstall/index.php?func=install">Install Charter Center <br /><br /></a><hr />';
                }
            }
    }
?>