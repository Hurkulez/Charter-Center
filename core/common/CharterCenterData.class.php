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

class CharterCenterData extends CodonData   {

    public function get_charters($flighttype)  {
        $query = "SELECT * FROM ".TABLE_PREFIX."schedules
                   JOIN ".TABLE_PREFIX."charter_added_by ON ".TABLE_PREFIX."schedules.id = ".TABLE_PREFIX."charter_added_by.charter_id
                   JOIN ".TABLE_PREFIX."pilots ON ".TABLE_PREFIX."pilots.pilotid = ".TABLE_PREFIX."charter_added_by.pilot_id
                   WHERE ".TABLE_PREFIX."schedules.flighttype='$flighttype'";
        
        return DB::get_results($query);
    }
    
   public function getpagnated($limit)   {
        $query = "SELECT * FROM ".TABLE_PREFIX."schedules
                   JOIN ".TABLE_PREFIX."charter_added_by ON ".TABLE_PREFIX."schedules.id = ".TABLE_PREFIX."charter_added_by.charter_id
                   JOIN ".TABLE_PREFIX."pilots ON ".TABLE_PREFIX."pilots.pilotid = ".TABLE_PREFIX."charter_added_by.pilot_id
                   WHERE ".TABLE_PREFIX."schedules.flighttype='H'
                    $limit";

        return DB::get_results($query);
    }

    public function get_country($iso)  {
        $query = "SELECT printable_name
                FROM ".TABLE_PREFIX."charter_countries
                WHERE iso='$iso'";
        $result=DB::get_row($query);
        return $result->printable_name;
    }

    public function get_airports()    {
        $query = "SELECT *
		FROM ".TABLE_PREFIX."charter_airports";

        return DB::get_results($query);
    }

    public function get_airport($icao)    {
        $query = "SELECT *
		FROM ".TABLE_PREFIX."charter_airports
                WHERE ident='$icao'";

        return DB::get_row($query);
    }

    public function search_airport($search, $country) {
        
        $query = "SELECT *
                    FROM ".TABLE_PREFIX."charter_airports
                    WHERE name LIKE '%$search%'
                    OR ident LIKE '%$search%'
                    AND country_iso='$country'";

        return DB::get_results($query);
    }

    public function check_for_duplicate($aircraft, $departure, $arrival) {

        $departure=(strtoupper($departure));
        $arrival=(strtoupper($arrival));
        $flighttype = 'H';
        $query = "SELECT COUNT(id) AS total
		FROM ".TABLE_PREFIX."schedules
                WHERE flighttype='$flighttype'
                AND aircraft='$aircraft'
                AND depicao='$departure'
                AND arricao='$arrival'";

        $result=DB::get_row($query);

        return $result->total;
    }

    public function get_last_flightnum()    {
        $query = "SELECT flightnum
                    AS max FROM ".TABLE_PREFIX."schedules
                    ORDER BY CAST(flightnum as UNSIGNED) DESC
                       LIMIT 1";

        $result = DB::get_row($query);

        return $result->max;
    }

    public function book_charter($charter) {

       $query = "INSERT INTO ".TABLE_PREFIX."schedules
					(code, flightnum,
					 depicao, arricao,
					 route, aircraft, flightlevel, distance,
					 deptime, arrtime,
					 flighttime, daysofweek, price,
					 flighttype, notes, enabled)
				VALUES ('$charter[code]',
						'$charter[flightnum]',
						'$charter[depicao]',
						'$charter[arricao]',
						'$charter[route]',
						'$charter[aircraft]',
						'$charter[flightlevel]',
						'$charter[distance]',
						'$charter[deptime]',
						'$charter[arrtime]',
						'$charter[flighttime]',
						'$charter[daysofweek]',
						'$charter[price]',
						'$charter[flighttype]',
						'$charter[notes]',
						'$charter[enabled]')";

		DB::query($query);

         $query2 = "SELECT id FROM ".TABLE_PREFIX."schedules
                    WHERE flightnum='$charter[flightnum]'";

                $id = DB::get_row($query2);
                $pilot_id = Auth::$userinfo->pilotid;

         $query3 = "INSERT INTO ".TABLE_PREFIX."charter_added_by (pilot_id, charter_id, date_added)
                    VALUES ('$pilot_id', '$id->id', NOW())";

                    DB::query($query3);
    }

    public function get_flown_charters($pid)    {
        $query = 'SELECT * FROM '.TABLE_PREFIX.'pireps
                   WHERE pilotid='.$pid.'
                   AND flighttype="H"';

        return DB::get_results($query);
    }

    public function add_airport($data)  {
        $sql = "INSERT INTO ".TABLE_PREFIX."airports
		(`icao`, `name`, `country`, `lat`, `lng` )
		VALUES ('{$data['icao']}', '{$data['name']}', '{$data['country']}',
			{$data['lat']}, {$data['lng']})";

		DB::query($sql);
    }
    
    public function delete_charter($id) {
        $query = "DELETE FROM ".TABLE_PREFIX."schedules WHERE id = '$id'";
        
        DB::query($query);
    }
}