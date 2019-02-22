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
    <h4>Create a new charter:</h4>
    <hr />
    <?php
        if(isset($errors))
        {echo '<div class="error">You Have Errors In Your Charter Booking</div>';}
        if(isset($message))
        {echo '<div class="error">'.$message.'</div>';}
    ?>
    <form action="<?php echo url('/CharterCenter');?>" method="post" enctype="multipart/form-data">
        <table>
            <?php
                if(isset($errors['aircraft']))
                {echo '<tr><td></td><td><font color="#FF0000">You Must Choose An Aircraft</font></td></tr>';}
            ?>
            <tr><td>Select the aircraft to be used for your charter flight.</td>
                <td>
                    <select name="aircraft">
                        <?php
                        if(isset($charter['aircraft']))
                        {
                            echo '<option value="'.$charter['aircraft']->id.'">'.$charter['aircraft']->fullname.'   ('.$charter['aircraft']->registration.')</option>';
                        }
                        echo '<option value="">Chose an aircraft</option>';
                        foreach ($aircraft as $airplane)
                        {
                            echo '<option value="'.$airplane->id.'">'.$airplane->fullname.'   ('.$airplane->registration.')</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <?php
                if(isset($errors['departure']))
                {
                    if($errors['departure'] == 'empty')
                    {
                        echo '<tr><td></td><td><font color="#FF0000">You Must Choose A Departure Airfield</font></td></tr>';
                    }
                    else
                    {
                        echo '<tr><td></td><td><font color="#FF0000">'.$errors['departure'].'</font></td></tr>';
                    }
                }
                if(isset($charter['departure']))
                        { ?>
                            <tr>
                                <td>Departure Airfield ICAO:</td>
                                <td>
                                    <input class="charterbox" name="dep" value="<?php echo $charter['departure']->ident; ?>" />
                                    <br /><br /><?php echo $charter['departure']->name; ?>
                                </td>
                            </tr>
                    <?php }
                    else
                    { ?>
            <tr>
                <td>Departure Airfield ICAO:</td>
                <td><input name="dep" value="" /></td>
            </tr>
            <?php
               }

            if(isset($errors['arrival']))
                {
                    if($errors['arrival'] == 'empty')
                    {
                        echo '<tr><td></td><td><font color="#FF0000">You Must Choose An Arrival Airfield</font></td></tr>';
                    }
                    else
                    {
                        echo '<tr><td></td><td><font color="#FF0000">'.$errors['arrival'].'</font></td></tr>';
                    }
                }
                if(isset($charter['arrival']))
                        { ?>
                            <tr>
                                <td>Departure Airfield ICAO:</td>
                                <td>
                                    <input class="charterbox" name="arr" value="<?php echo $charter['arrival']->ident; ?>" />
                                    <br /><br /><?php echo $charter['arrival']->name; ?>
                                </td>
                            </tr>
                    <?php }
                    else
                    { ?>
            <tr>
                <td>Arrival Airfield ICAO:</td>
                <td><input name="arr" value="" /></td>
            </tr>
            <?php
               }
            ?>
            
            <tr>
                <td colspan="2">
                    <input type="hidden" name="action" value="create_route" />
                    <input type="submit" value="Create Route" />
                </td>
            </tr>

        </table>
    </form>