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
    <h4>Charter's Flown</h4>
    <hr />
<table>
<thead>
<tr>
	<th width="10%">Date</th>
        <th width="10%">Flight Number</th>
        <th width="10%">Departure</th>
	<th width="10%">Arrival</th>
	<th width="50%">Aircraft</th>
	<th width="10%">Distance</th>
</tr>
</thead>
<tbody>
<?php
    if(!$flights)
    {
        echo '<tr><td colspan="6">No Charters Flown</td></tr>';
    }
    else
    {
    foreach($flights as $charter)
    {
            $aircraft = OperationsData::getAircraftInfo($charter->aircraft);
            $disunit = Config::Get('DistanceUnit');
                    if($disunit == 0){$unit = ' km';}
                    if($disunit == 1){$unit - ' mi';}
                    else{$unit = ' nm';}
            echo '<tr>
                    <td>'.date('m/d/Y', strtotime($charter->submitdate)).'</td>
                    <td>'.$charter->code . $charter->flightnum.'</td>
                    <td>'.$charter->depicao.'</td>
                    <td>'.$charter->arricao.'</td>
                    <td>'.$aircraft->fullname.' ('.$aircraft->registration.')</td>
                    <td>'.$charter->distance.''.$unit.'</td>
                 </tr>';
    }
    }
?>
</tbody>
</table>