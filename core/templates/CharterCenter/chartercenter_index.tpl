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
?>
    <?php
        if(isset($message))
        {echo '<div style="background: #FFFF33; text-align: center; padding: 5px">'.$message.'</div>';}
    ?>
    <h4>Welcome To The Charter Center <?php echo Auth::$userinfo->firstname; ?></h4>
    <?php if(Auth::LoggedIn())
    { ?>
    | <a href="<?php echo SITE_URL ?>/index.php/chartercenter">Charter Center Listings</a>
    | <a href="<?php echo SITE_URL ?>/index.php/chartercenter/create">Create A New Charter</a>
    | <a href="<?php echo SITE_URL ?>/index.php/chartercenter/flown">My Charter History</a> |
    <?php
    }
    ?>
    <hr />