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

class CharterCenter extends CodonModule {

    public function HTMLHead()
    {
        $this->set('sidebar', 'CharterCenter/sidebar_charter.tpl');
    }

    public function NavBar()
    {
        echo '<li><a href="'.SITE_URL.'/admin/index.php/CharterCenter">Charter Center</a></li>';
    }
    
    function index()    {
        
        if (isset($_GET['page']))
                {$page = (int) $_GET['page'];}
            else
                {$page = 1;}
            // how many records per page
            $size = 15;
            $tot = "SELECT COUNT(*)AS total FROM ".TABLE_PREFIX."schedules WHERE flighttype = 'H'";
            $total = DB::get_row($tot);
            $this->set('size', $size);
            $this->set('page', $page);
            $this->set('total', $total->total);
            
        $this->show('CharterCenter/charter_index.tpl');
        $this->show('CharterCenter/charter_footer.tpl');
    }
    
    function delete_charter($id)    {
        CharterCenterData::delete_charter($id);
        $this->set('message', 'Charter Deleted');
        $this->index();
    }
    
}