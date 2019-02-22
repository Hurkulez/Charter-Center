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
<br />
<h4>Charter <?php echo $route->code . $route->flightnum; ?>  (Aircraft - <?php echo $aircraft->registration; ?>)</h4>
<br />
    <table>
        <tr>
            <th colspan="2">Aircraft</th>
        </tr>
    <tr>
        <td><u>Type:</u></td>
        <td><?php echo $aircraft->icao; ?></td>
    </tr>
    <tr>
        <td><u>Description:</u></td>
        <td><?php echo $aircraft->fullname; ?></td>
    </tr>
    <tr>
        <td><u>Registration:</u></td>
        <td><?php echo $aircraft->registration; ?></td>
    </tr>
    </table>
<table>
    <tr>
        <th>
            Flight Routing
        </th>
    </tr>
    <?php
                echo '<tr>';
                echo '<td>Flight: '.$route->code . $route->flightnum. ' / '.$route->depicao.' - '.$route->arricao.' / '.$route->distance.' nm</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>Route: '.$route->route.'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>Times Flown: '.$route->timesflown.'</td>';
                echo '</tr>';
    ?>
</table>
  <hr />
    <h4>Route Map For <?php echo $aircraft->registration; ?> - <?php echo $aircraft->icao; ?></h4><br />
    <center>
    <img src="http://www.gcmap.com/map?P=<?php echo $route->depicao.'-'.$route->arricao; ?>,&PM=pemr%3Adiamond7%2B%25U&MS=bm&DU=mi" alt="map" />
    <br />
        <font size="1">
            Maps generated by the
            <a href="http://www.gcmap.com/">Great Circle Mapper</a>&nbsp;-
            copyright &#169; <a href="http://www.kls2.com/~karl/">Karl L. Swartz</a>.
        </font>
    </center>