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
<div class="wideright">
    <h4>Verify Charter Booking</h4><hr />
    
    <form action="<?php echo url('/CharterCenter');?>" method="post" enctype="multipart/form-data">
        <table class="charter">
        <tr>
            <td bgcolor="#cccccc" align="right">Pilot</td>
            <td><?php echo Auth::$userinfo->firstname.' '.Auth::$userinfo->lastname; ?></td>
            <td colspan="4" align="left"><?php echo PilotData::getPilotCode(Auth::$userinfo->code, Auth::$userinfo->pilotid); ?></td>
         </tr>
        <tr>
            <td bgcolor="#cccccc" align="right">Aircraft:</td>
            <td><?php echo $aircraft->code; ?></td>
            <td colspan="4" align="left"><?php echo $aircraft->name; ?></td>
         </tr>
        <tr>
            <td bgcolor="#cccccc" align="right">Departure Airfield:</td>
            <td><?php echo $charter['departure']->ident; ?></td>
            <td><?php echo $charter['departure']->name; ?></td>
            <td><?php echo $charter['departure']->municipality; ?></td>
            <td align="right"><?php echo CharterCenterData::get_country($departure->country_iso); ?></td>
            <td width="5%"><img src="<?php echo SITE_URL.'/lib/images/countries/'.strtolower($charter['departure']->country_iso); ?>.png" alt="Flag" /></td>
        </tr>
        <tr>
            <td bgcolor="#cccccc" align="right">Arrival Airfield:</td>
            <td><?php echo $charter['arrival']->ident; ?></td>
            <td><?php echo $charter['arrival']->name; ?></td>
            <td><?php echo $charter['arrival']->municipality; ?></td>
            <td align="right"><?php echo CharterCenterData::get_country($arrival->country_iso); ?></td>
            <td width="5%"><img src="<?php echo SITE_URL.'/lib/images/countries/'.strtolower($charter['arrival']->country_iso); ?>.png" alt="Flag" /></td>
        </tr>
        <tr>
            <td bgcolor="#cccccc" align="right">Distance:</td>
            <td colspan="5" class="last">
                <?php
                    $distance = round(SchedulesData::distanceBetweenPoints($charter['departure']->latitude, $charter['departure']->longitude,
                                $charter['arrival']->latitude, $charter['arrival']->longitude), 0);
                    echo $distance;
                    $disunit = Config::Get('DistanceUnit');
                    if($disunit == 0){$unit = ' km';}
                    if($disunit == 1){$unit - ' mi';}
                    else{$unit = ' nm';}
                    echo $unit;

                    if(isset($errors)){echo $errors['aircraft'];}

                    ?>
            </td>
        </tr>
        <tr>
            <td bgcolor="#cccccc" align="right">Flight Level:<br />(optional)</td>
            <td colspan="5" align="left"><input type="text" class="charterbox" name="flightlevel" value="" /></td>
         </tr>
        <tr>
            <td bgcolor="#cccccc" align="right">Route:<br />(optional)</td>
            <td colspan="5" align="left"><input type="text" class="charterbox" name="route" value="" /></td>
         </tr>
         <tr>
            <td bgcolor="#cccccc" align="right">Book Charter:</td>
            <td colspan="5" class="last">
                <input type="hidden" name="depicao" value="<?php echo $charter['departure']->ident; ?>" />
                <input type="hidden" name="arricao" value="<?php echo $charter['arrival']->ident; ?>" />
                <input type="hidden" name="aircraft" value="<?php echo $aircraft->id; ?>" />
                <input type="hidden" name="distance" value="<?php echo round($distance, 0); ?>" />
                <input type="hidden" name="action" value="book" />
                <input class="charter" type="submit" value="Book Now" />
            </td>
        </tr>
    </table>
    </form>
</div>