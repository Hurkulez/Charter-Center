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

$pagination = new CharterPagination();
$pagination->setLink("chartercenter?page=%s");
$pagination->setPage($page);
$pagination->setSize($size);
$pagination->setTotalRecords($total);
$charters = CharterCenterData::getpagnated($pagination->getLimitSql());

if(isset($message))
{
    echo '<font color="#FF0000">'.$message.'</font><hr />';
}
?>
    <h5>Charter Listings</h5>
    <hr />
<table>
<thead>
<tr>
	<th width="8%">Flight #</th>
        <th width="8%">Departure</th>
	<th width="8%">Arrival</th>
	<th width="20%">Aircraft</th>
	<th width="6%">Distance</th>
	<th width="10%">Times Flown</th>
        <th width="30%">Added By</th>
        <th width="10%">Delete</th>
</tr>
</thead>
<tbody>
<?php
    if(!$charters)
        {echo '<tr><td colspan="7">No Charters Exist</td></tr>';}
    else
    {
    foreach($charters as $charter)
    {
            $aircraft = OperationsData::getAircraftInfo($charter->aircraft);
            $disunit = Config::Get('DistanceUnit');
                    if($disunit == 0){$unit = ' km';}
                    if($disunit == 1){$unit - ' mi';}
                    else{$unit = ' nm';}
            echo '<tr>
                    <td><a href="'.SITE_URL.'/index.php/CharterCenter/charter/'.$charter->charter_id.'/'.$aircraft->id.'">'.$charter->code . $charter->flightnum.'</a></td>
                    <td align="center">'.$charter->depicao.'</td>
                    <td align="center">'.$charter->arricao.'</td>
                    <td>'.$aircraft->fullname.'</td>
                    <td>'.round($charter->distance, 0).''.$unit.'</td>
                    <td align="center">'.$charter->timesflown.'</td>
                    <td>'.$charter->firstname.' '.$charter->lastname.' ('.PilotData::getPilotCode($charter->code, $charter->pilotid).') on '.date(DATE_FORMAT, strtotime($charter->date_added)).'</td>
                    <td><a href="'.adminurl('/CharterCenter/delete_charter/').$charter->charter_id.'"
                        onclick="return confirm(\'Are you sure you want to delete this charter? This action can not be reversed.\')"">Delete</a></td>
                    </tr>';
    }
    }
?>
</tbody>
</table>
<?php
    $navigation = $pagination->create_links();
    echo $navigation;
?>