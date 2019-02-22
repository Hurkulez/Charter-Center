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

    public $title = 'Charter Center';

    public function index() {

        if(isset($this->post->action))
        {
            if($this->post->action == 'create_route') {
                $this->create_route();
            }
            if($this->post->action == 'book') {
                $this->book();
            }
        }
        else
        {
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
            
            $this->render('CharterCenter/chartercenter_index.tpl');
            $this->render('CharterCenter/chartercenter_charters.tpl');
        }
    }

    public function charters()  {
        $this->set('charters', CharterCenterData::get_charters('H'));
        $this->render('CharterCenter/chartercenter_index.tpl');
        $this->render('CharterCenter/chartercenter_charters.tpl');
    }

    public function charter($id, $ac)   {
        $this->set('aircraft', OperationsData::getAircraftInfo($ac));
        $this->set('route', SchedulesData::getschedule($id));
        $this->render('CharterCenter/chartercenter_index.tpl');
        $this->show('CharterCenter/chartercenter_charter.tpl');
    }

    public function create()    {
        if(!Auth::LoggedIn()) {
            $this->set('message', 'You must be logged in to access this feature!');
            $this->render('core_error.tpl');
            return;
        }
        $this->set('aircraft', OperationsData::getAllAircraft());
        $this->render('CharterCenter/chartercenter_index.tpl');
        $this->render('CharterCenter/chartercenter_create.tpl');
    }

    protected function create_route()   {
        $charter = array();
        
        $aircraft = DB::escape($this->post->aircraft);
            if(!$aircraft)
                {$errors['aircraft'] = 'empty';}
            else
            {
                $charter['aircraft'] = OperationsData::getAircraftInfo($aircraft);
            }
        
        $departure = DB::escape($this->post->dep);
            if(!$departure)
                {$errors['departure'] = 'empty';}
            else
                {
                    $charter['departure'] = CharterCenterData::get_airport($departure);
                    if(!$charter['departure'])
                    {$errors['departure'] = $departure.' Does Not Exist In The Database';}
                }
        
        $arrival = DB::escape($this->post->arr);
            if(!$arrival)
                {$errors['arrival'] = 'empty';}
            else
                {
                    $charter['arrival'] = CharterCenterData::get_airport($arrival);
                    if(!$charter['arrival'])
                    {$errors['arrival'] = $arrival.' Does Not Exist In The Database';}
                }
        $duplicate = CharterCenterData::check_for_duplicate($charter[aircraft]->id, $departure, $arrival);
                    if($duplicate > 0)
                    {
                        $errors['message'] = 'duplicate';
                        $this->set('message', 'This Charter Already Exists! Please Book The Flight Through The Charter Listings Tab');
                        $this->charters();
                    }
                    else
                    {
        if(isset($errors))
            {
                $this->set('errors', $errors);
                $this->set('charter', $charter);
                $this->set('airlines', OperationsData::getAllAirlines());
                $this->set('aircraft', OperationsData::getAllAircraft());
                $this->render('CharterCenter/chartercenter_index.tpl');
                $this->render('CharterCenter/chartercenter_create.tpl');
            }
        else
            {
                $this->set('charter', $charter);
                $this->set('aircraft', OperationsData::getAircraftInfo($aircraft));
                $this->render('CharterCenter/chartercenter_index.tpl');
                $this->render('CharterCenter/chartercenter_verify.tpl');
            }
                    }
    }

    protected function book()   {
        $aircraft = OperationsData::getAircraftInfo(DB::escape($this->post->aircraft));
        //check for the last charter flight number and create the next one for this flight
        $checkflightnum = CharterCenterData::get_last_flightnum();
        if($checkflightnum == '' || $checkflightnum < 10000)
            { $flightnum = 10000; }//starting flight number for charters
        else
        { $flightnum = ($checkflightnum + 1); }
        $depicao = DB::escape($this->post->depicao);
        $arricao = DB::escape($this->post->arricao);
        $distance = DB::escape($this->post->distance);
        $route = DB::escape($this->post->route);
        $flightlevel = DB::escape($this->post->flightlevel);
        if(!$route)
        {$route = 'No Route Available';}
                $charter = array();
                        $charter[code] = Auth::$userinfo->code;
			$charter[flightnum] = $flightnum;
			$charter[depicao] = $depicao;
			$charter[arricao] = $arricao;
			$charter[route] = $route;
			$charter[aircraft] = $aircraft->id;
			$charter[flightlevel] = $flightlevel;
			$charter[distance] = $distance;
			$charter[deptime] = '';
			$charter[arrtime] = '';
			$charter[flighttime] = '';
			$charter[daysofweek] = '0123456';
			$charter[price] = '';
			$charter[flighttype] = 'H';
			$charter[notes] = 'Charter Flight';
			$charter[enabled] = '1';

                        CharterCenterData::book_charter($charter);

        $dep = CharterCenterData::get_airport($depicao);
        
        $data = array(
			'icao' => $dep->ident,
			'name' => $dep->name,
			'country' => CharterCenterData::get_country($dep->country_iso),
			'lat' => $dep->latitude,
			'lng' => $dep->longitude
			);

		CharterCenterData::add_airport($data);

        $arr = CharterCenterData::get_airport($arricao);

        $data2 = array(
                'icao' => $arr->ident,
                'name' => $arr->name,
                'country' => CharterCenterData::get_country($arr->country_iso),
                'lat' => $arr->latitude,
                'lng' => $arr->longitude
                );

		CharterCenterData::add_airport($data2);
                
        header('Location: '.url('/chartercenter'));
    }

    public function flown() {
        if(!Auth::LoggedIn()) {
            $this->set('message', 'You must be logged in to access this feature!');
            $this->render('core_error.tpl');
            return;
        }
        $pid = Auth::$userinfo->pilotid;
        $this->set('flights', CharterCenterData::get_flown_charters($pid));
        $this->render('CharterCenter/chartercenter_index.tpl');
        $this->render('CharterCenter/chartercenter_flown.tpl');
    }
}