<?php

require_once 'Settings.php';
require_once __DIR__.'/../utils/Log.php';

Class UserData {

        private $globalconf;
        private $con;
        private $l;
        private $s;

        public function __construct()
        {
                $this->l = new Log();

        }

        public function UserDataOperation($action, $params, $con)
        {
                if ($action == 'getall') {
                        $this->GetAll($params, $con);
                } 
        }

        private function GetAll($params, $con) {
                $sql = '';
                $username = isset($params->username) ? $params->username : (isset($params['username']) ? $params['username'] : 'empty');
                $objdata = isset($params->objdata) ? $params->objdata : (isset($params['objdata']) ? $params['objdata'] : 'empty');
		$userdata = isset($params->userdata) ? $params->userdata : (isset($params['userdata']) ? $params['userdata'] : 'empty');
		$refreshview = isset($params->refreshview) ? $params->refreshview : (isset($params['refreshview']) ? $params['refreshview'] : 'empty');
		$refreshobj = isset($params->refreshobj) ? $params->refreshobj : (isset($params['refreshobj']) ? $params['refreshobj'] : 'empty');

		if ($userdata == 'empty') {
                $userdata = array();
                $userdata['username'] = $username;
		$userdata = $this->GetGroups($userdata, $con);
		$userdata = $this->GetNocViews($userdata, $con);
		$userdata = $this->GetViewObjects($userdata, $objdata, $con);
		} else {
		$userdata['refreshview'] = $refreshview;
		$userdata['refreshobj'] = $refreshobj;
		$userdata = $this->GetViewObjects($userdata, $objdata, $con);
		}

                $jrows = json_encode($userdata);
                header('Content-Type: application/json');
                echo $jrows;
        }

	private function GetGroups($userdata, $con) {

		$username = $userdata['username'];
                $sql = "select groupid from user_groups where username = '$username'";
                $response = $con->query($sql);
                $records = array();
                $rows = array();
                $recid = 1;
                while ($obj = $response->fetch_assoc())
                        {
                                $obj['recid'] = $recid;
                                $rows[] = $obj;
                                $recid = $recid + 1;
                        }
                $records['groups'] = $rows;
                return $records;
	}
	

        private function GetNocViews($userdata, $con) {

                $groups = $userdata['groups'];
		$records = $userdata;
		$records['views'] = array();

		foreach ($groups as $group) {	
			$groupid = $group['groupid'];
			$sql = "select * from nocviews where nocviewname in (select nocviewname from nocview_groups where groupid = '$groupid')";
			$response = $con->query($sql);
			$rows = array();
			$recid = 1;
			while ($obj = $response->fetch_assoc())
				{
					$obj['recid'] = $recid;
					$viewname = $obj['nocviewname'];
					$records['views'][$viewname] = $obj;
					$recid = $recid + 1;
				}
		}
                return $records;
        }

	private function GetViewObjects ($userdata, $objdata, $con) {

                $views = $userdata['views'];
		$refreshview = isset($userdata['refreshview']) ? $userdata['refreshview'] : 'no';
		$refreshobj = isset($userdata['refreshobj']) ? $userdata['refreshobj'] : 'no';
                $records = $userdata;
		
		if ($refreshview !== 'no' || $refreshobj !== 'no') {
                        $sql = "select * from viewobjects where objname = '$refreshobj'";
                        $response = $con->query($sql);
                        $rows = array();
                        $recid = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['recid'] = $recid;
                                        $records['views'][$refreshview]['viewobjects'][$refreshobj] = $obj;
                                        $recid = $recid + 1;
                                }
		        $gridcolumns = $records['views'][$refreshview]['viewobjects'][$refreshobj]['gridcolumns'];
                        $gridcolumns = str_replace(array("\n", "\t", "\r"), '', $gridcolumns);
                        $gridcolumns = json_decode($gridcolumns);
                        $records['views'][$refreshview]['viewobjects'][$refreshobj]['gridcolumns'] = $gridcolumns;
                        $contextmenu = $records['views'][$refreshview]['viewobjects'][$refreshobj]['contextmenu'];
                        $toolbarmenu = $records['views'][$refreshview]['viewobjects'][$refreshobj]['toolbarmenu'];
                        $setname = $records['views'][$refreshview]['viewobjects'][$refreshobj]['setname'];
                        $refreshrate = $records['views'][$refreshview]['viewobjects'][$refreshobj]['refreshrate'];
                        $objtype = $records['views'][$refreshview]['viewobjects'][$refreshobj]['objtype'];
                        $records = $this->GetMenuTools($records,$refreshview,$refreshobj,$contextmenu,'contextmenu',$con);
                        $records = $this->GetMenuTools($records,$refreshview,$refreshobj,$toolbarmenu,'toolbarmenu',$con);
                        $records = $this->GetDataSet($records,$refreshview,$refreshobj,$setname,$con);
                        if ($objtype == 'grid') {
                        $con_name = $records['views'][$refreshview]['viewobjects'][$refreshobj]['dataset']['connectionname'];
                        $records = $this->GetConnection($records,$refreshview,$refreshobj,$con_name,$con);
                        $con_type = $records['views'][$refreshview]['viewobjects'][$refreshobj]['connection']['connectiontype'];
				if ($objdata !== 'no') {
				$records = $this->GetViewData($records,$refreshview,$refreshobj,$con_type,$con);
				$format = $records['views'][$refreshview]['viewobjects'][$refreshobj]['colformat'];
				$format = str_replace(array("\n", "\t", "\r"), '', $format);
				$format = json_decode($format);
				$reststartproperty = $records['views'][$refreshview]['viewobjects'][$refreshobj]['reststartproperty'];
				$records = $this->FormatData($records,$refreshview,$refreshobj,$gridcolumns, $reststartproperty,$format,$con);
				}
			}
		} else {
		

                foreach ($views as $view) {

			$viewname = $view['nocviewname'];
                        $topname = $view['toppanel'];
                        $bottomname = $view['bottompanel'];
                        $leftname = $view['leftpanel'];
                        $rightname = $view['rightpanel'];
                        $mainname = $view['mainpanel'];
                        $previewname = $view['previewpanel'];

			if (strlen($topname) > 0) {
                        $sql = "select * from viewobjects where objname = '$topname'";
                        $response = $con->query($sql);
                        $rows = array();
                        $recid = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['recid'] = $recid;
                                        $records['views'][$viewname]['viewobjects']['toppanel'] = $obj;
                                        $recid = $recid + 1;
                                }

			$gridcolumns = $records['views'][$viewname]['viewobjects']['toppanel']['gridcolumns'];
			$gridcolumns = str_replace(array("\n", "\t", "\r"), '', $gridcolumns);
			$gridcolumns = json_decode($gridcolumns);
			$records['views'][$viewname]['viewobjects']['toppanel']['gridcolumns'] = $gridcolumns;
			
			$contextmenu = $records['views'][$viewname]['viewobjects']['toppanel']['contextmenu'];
			$toolbarmenu = $records['views'][$viewname]['viewobjects']['toppanel']['toolbarmenu'];
			$setname = $records['views'][$viewname]['viewobjects']['toppanel']['setname'];
			$refreshrate = $records['views'][$viewname]['viewobjects']['toppanel']['refreshrate'];
			$objtype = $records['views'][$viewname]['viewobjects']['toppanel']['objtype'];

			$records = $this->GetMenuTools($records,$viewname,'toppanel',$contextmenu,'contextmenu',$con);
			$records = $this->GetMenuTools($records,$viewname,'toppanel',$toolbarmenu,'toolbarmenu',$con);
			$records = $this->GetDataSet($records,$viewname,'toppanel',$setname,$con);

			if ($objtype == 'grid') {
			$con_name = $records['views'][$viewname]['viewobjects']['toppanel']['dataset']['connectionname'];
			$records = $this->GetConnection($records,$viewname,'toppanel',$con_name,$con);

			$con_type = $records['views'][$viewname]['viewobjects']['toppanel']['connection']['connectiontype'];
				if ($objdata !== 'no') {
				$records = $this->GetViewData($records,$viewname,'toppanel',$con_type,$con);

				$format = $records['views'][$viewname]['viewobjects']['toppanel']['colformat'];
				$format = str_replace(array("\n", "\t", "\r"), '', $format);
				$format = json_decode($format);
				$reststartproperty = $records['views'][$viewname]['viewobjects']['toppanel']['reststartproperty'];
				$records = $this->FormatData($records,$viewname,'toppanel',$gridcolumns, $reststartproperty,$format,$con);
				}
			}

			}

			if (strlen($bottomname) > 0) {
                        $sql = "select * from viewobjects where objname = '$bottomname'";
                        $response = $con->query($sql);
                        $rows = array();
                        $recid = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['recid'] = $recid;
                                        $records['views'][$viewname]['viewobjects']['bottompanel'] = $obj;
                                        $recid = $recid + 1;
                                }
			$gridcolumns = $records['views'][$viewname]['viewobjects']['bottompanel']['gridcolumns'];
			$gridcolumns = str_replace(array("\n", "\t", "\r"), '', $gridcolumns);
			$gridcolumns = json_decode($gridcolumns);
			$records['views'][$viewname]['viewobjects']['bottompanel']['gridcolumns'] = $gridcolumns;

			$contextmenu = $records['views'][$viewname]['viewobjects']['bottompanel']['contextmenu'];
			$toolbarmenu = $records['views'][$viewname]['viewobjects']['bottompanel']['toolbarmenu'];
			$setname = $records['views'][$viewname]['viewobjects']['bottompanel']['setname'];
			$refreshrate = $records['views'][$viewname]['viewobjects']['bottompanel']['refreshrate'];
			$objtype = $records['views'][$viewname]['viewobjects']['bottompanel']['objtype'];

			if ($objtype == 'grid') {
			$records = $this->GetMenuTools($records,$viewname,'bottompanel',$contextmenu,'contextmenu',$con);
			$records = $this->GetMenuTools($records,$viewname,'bottompanel',$toolbarmenu,'toolbarmenu',$con);
			$records = $this->GetDataSet($records,$viewname,'bottompanel',$setname,$con);


			$con_name = $records['views'][$viewname]['viewobjects']['bottompanel']['dataset']['connectionname'];
			$records = $this->GetConnection($records,$viewname,'bottompanel',$con_name,$con);
			$con_type = $records['views'][$viewname]['viewobjects']['bottompanel']['connection']['connectiontype'];
				if ($objdata !== 'no') {
				$records = $this->GetViewData($records,$viewname,'bottompanel',$con_type,$con);
				$format = $records['views'][$viewname]['viewobjects']['bottompanel']['colformat'];
				$format = str_replace(array("\n", "\t", "\r"), '', $format);
				$format = json_decode($format);
				$reststartproperty = $records['views'][$viewname]['viewobjects']['bottompanel']['reststartproperty'];
				$records = $this->FormatData($records,$viewname,'bottompanel',$gridcolumns, $reststartproperty,$format,$con);
				}
			}


                        }

			if (strlen($rightname) > 0) {
                        $sql = "select * from viewobjects where objname = '$rightname'";
                        $response = $con->query($sql);
                        $rows = array();
                        $recid = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['recid'] = $recid;
                                        $records['views'][$viewname]['viewobjects']['rightpanel'] = $obj;
                                        $recid = $recid + 1;
                                }
			$gridcolumns = $records['views'][$viewname]['viewobjects']['rightpanel']['gridcolumns'];
			$gridcolumns = str_replace(array("\n", "\t", "\r"), '', $gridcolumns);
			$gridcolumns = json_decode($gridcolumns);
			$records['views'][$viewname]['viewobjects']['rightpanel']['gridcolumns'] = $gridcolumns;

			$contextmenu = $records['views'][$viewname]['viewobjects']['rightpanel']['contextmenu'];
			$toolbarmenu = $records['views'][$viewname]['viewobjects']['rightpanel']['toolbarmenu'];
			$setname = $records['views'][$viewname]['viewobjects']['rightpanel']['setname'];
			$refreshrate = $records['views'][$viewname]['viewobjects']['rightpanel']['refreshrate'];
			$objtype = $records['views'][$viewname]['viewobjects']['rightpanel']['objtype'];

			if ($objtype == 'grid') {

			$records = $this->GetMenuTools($records,$viewname,'rightpanel',$contextmenu,'contextmenu',$con);
			$records = $this->GetMenuTools($records,$viewname,'rightpanel',$toolbarmenu,'toolbarmenu',$con);
			$records = $this->GetDataSet($records,$viewname,'rightpanel',$setname,$con);

			$con_name = $records['views'][$viewname]['viewobjects']['rightpanel']['dataset']['connectionname'];
			$records = $this->GetConnection($records,$viewname,'rightpanel',$con_name,$con);
			$con_type = $records['views'][$viewname]['viewobjects']['rightpanel']['connection']['connectiontype'];
				if ($objdata !== 'no') {
				$records = $this->GetViewData($records,$viewname,'rightpanel',$con_type,$con);
				$format = $records['views'][$viewname]['viewobjects']['rightpanel']['colformat'];
				$format = str_replace(array("\n", "\t", "\r"), '', $format);
				$format = json_decode($format);
				$reststartproperty = $records['views'][$viewname]['viewobjects']['rightpanel']['reststartproperty'];
				$records = $this->FormatData($records,$viewname,'rightpanel',$gridcolumns, $reststartproperty,$format,$con);
				}
			}

                        }



			if (strlen($leftname) > 0) {
                        $sql = "select * from viewobjects where objname = '$leftname'";
                        $response = $con->query($sql);
                        $rows = array();
                        $recid = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['recid'] = $recid;
                                        $records['views'][$viewname]['viewobjects']['leftpanel'] = $obj;
                                        $recid = $recid + 1;
                                }
			$gridcolumns = $records['views'][$viewname]['viewobjects']['leftpanel']['gridcolumns'];
			$gridcolumns = str_replace(array("\n", "\t", "\r"), '', $gridcolumns);
			$gridcolumns = json_decode($gridcolumns);
			$records['views'][$viewname]['viewobjects']['leftpanel']['gridcolumns'] = $gridcolumns;

			$contextmenu = $records['views'][$viewname]['viewobjects']['leftpanel']['contextmenu'];
			$toolbarmenu = $records['views'][$viewname]['viewobjects']['leftpanel']['toolbarmenu'];
			$setname = $records['views'][$viewname]['viewobjects']['leftpanel']['setname'];
			$refreshrate = $records['views'][$viewname]['viewobjects']['leftpanel']['refreshrate'];
			$objtype = $records['views'][$viewname]['viewobjects']['leftpanel']['objtype'];

			if ($objtype == 'grid') {

			$records = $this->GetMenuTools($records,$viewname,'leftpanel',$contextmenu,'contextmenu',$con);
			$records = $this->GetMenuTools($records,$viewname,'leftpanel',$toolbarmenu,'toolbarmenu',$con);
			$records = $this->GetDataSet($records,$viewname,'leftpanel',$setname,$con);

			$con_name = $records['views'][$viewname]['viewobjects']['leftpanel']['dataset']['connectionname'];
			$records = $this->GetConnection($records,$viewname,'leftpanel',$con_name,$con);
			$con_type = $records['views'][$viewname]['viewobjects']['leftpanel']['connection']['connectiontype'];
				if ($objdata !== 'no') {
				$records = $this->GetViewData($records,$viewname,'leftpanel',$con_type,$con);
				$format = $records['views'][$viewname]['viewobjects']['leftpanel']['colformat'];
				$format = str_replace(array("\n", "\t", "\r"), '', $format);
				$format = json_decode($format);
				$reststartproperty = $records['views'][$viewname]['viewobjects']['leftpanel']['reststartproperty'];
				$records = $this->FormatData($records,$viewname,'leftpanel',$gridcolumns, $reststartproperty,$format,$con);
				}
			}

                        }

                        if (strlen($mainname) > 0) {
                        $sql = "select * from viewobjects where objname = '$mainname'";
                        $response = $con->query($sql);
                        $rows = array();
                        $recid = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['recid'] = $recid;
                                        $records['views'][$viewname]['viewobjects']['mainpanel'] = $obj;
                                        $recid = $recid + 1;
                                }
			$gridcolumns = $records['views'][$viewname]['viewobjects']['mainpanel']['gridcolumns'];
			$gridcolumns = str_replace(array("\n", "\t", "\r"), '', $gridcolumns);
			$gridcolumns = json_decode($gridcolumns);
			$records['views'][$viewname]['viewobjects']['mainpanel']['gridcolumns'] = $gridcolumns;

			$contextmenu = $records['views'][$viewname]['viewobjects']['mainpanel']['contextmenu'];
			$toolbarmenu = $records['views'][$viewname]['viewobjects']['mainpanel']['toolbarmenu'];
			$setname = $records['views'][$viewname]['viewobjects']['mainpanel']['setname'];
			$refreshrate = $records['views'][$viewname]['viewobjects']['mainpanel']['refreshrate'];
			$objtype = $records['views'][$viewname]['viewobjects']['mainpanel']['objtype'];

			if ($objtype == 'grid') {
			$records = $this->GetMenuTools($records,$viewname,'mainpanel',$contextmenu,'contextmenu',$con);
			$records = $this->GetMenuTools($records,$viewname,'mainpanel',$toolbarmenu,'toolbarmenu',$con);
			$records = $this->GetDataSet($records,$viewname,'mainpanel',$setname,$con);

			$con_name = $records['views'][$viewname]['viewobjects']['mainpanel']['dataset']['connectionname'];
			$records = $this->GetConnection($records,$viewname,'mainpanel',$con_name,$con);
			$con_type = $records['views'][$viewname]['viewobjects']['mainpanel']['connection']['connectiontype'];
				if ($objdata !== 'no') {
				$records = $this->GetViewData($records,$viewname,'mainpanel',$con_type,$con);
				$format = $records['views'][$viewname]['viewobjects']['mainpanel']['colformat'];
				$format = str_replace(array("\n", "\t", "\r"), '', $format);
				$format = json_decode($format);
				$reststartproperty = $records['views'][$viewname]['viewobjects']['mainpanel']['reststartproperty'];
				$records = $this->FormatData($records,$viewname,'mainpanel',$gridcolumns, $reststartproperty,$format,$con);
				}
			}

                        }

                        if (strlen($previewname) > 0) {
                        $sql = "select * from viewobjects where objname = '$previewname'";
                        $response = $con->query($sql);
                        $rows = array();
                        $recid = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['recid'] = $recid;
                                        $records['views'][$viewname]['viewobjects']['previewpanel'] = $obj;
                                        $recid = $recid + 1;
                                }
			$gridcolumns = $records['views'][$viewname]['viewobjects']['previewpanel']['gridcolumns'];
			$gridcolumns = str_replace(array("\n", "\t", "\r"), '', $gridcolumns);
			$gridcolumns = json_decode($gridcolumns);
			$records['views'][$viewname]['viewobjects']['previewpanel']['gridcolumns'] = $gridcolumns;

			$contextmenu = $records['views'][$viewname]['viewobjects']['previewpanel']['contextmenu'];
			$toolbarmenu = $records['views'][$viewname]['viewobjects']['previewpanel']['toolbarmenu'];
			$setname = $records['views'][$viewname]['viewobjects']['previewpanel']['setname'];
			$refreshrate = $records['views'][$viewname]['viewobjects']['previewpanel']['refreshrate'];
			$objtype = $records['views'][$viewname]['viewobjects']['previewpanel']['objtype'];

			if ($objtype == 'grid') {
			$records = $this->GetMenuTools($records,$viewname,'previewpanel',$contextmenu,'contextmenu',$con);
			$records = $this->GetMenuTools($records,$viewname,'previewpanel',$toolbarmenu,'toolbarmenu',$con);
			$records = $this->GetDataSet($records,$viewname,'previewpanel',$setname,$con);

			$con_name = $records['views'][$viewname]['viewobjects']['previewpanel']['dataset']['connectionname'];
			$records = $this->GetConnection($records,$viewname,'previewpanel',$con_name,$con);

			$con_type = $records['views'][$viewname]['viewobjects']['previewpanel']['connection']['connectiontype'];
				if ($objdata !== 'no') {
				$records = $this->GetViewData($records,$viewname,'previewpanel',$con_type,$con);
				$format = $records['views'][$viewname]['viewobjects']['previewpanel']['colformat'];
				$format = str_replace(array("\n", "\t", "\r"), '', $format);
				$format = json_decode($format);
				$reststartproperty = $records['views'][$viewname]['viewobjects']['previewpanel']['reststartproperty'];
				$records = $this->FormatData($records,$viewname,'previewpanel',$gridcolumns, $reststartproperty,$format,$con);
				}
			}
				
                        }
                }
		}
                return $records;
	}

	private function GetMenuTools($records,$viewname,$panelname,$menuname,$menutype,$con) {

		$groups = $records['groups'];
		$groupnames = array();
	
		foreach ($groups as $group){
			$groupnames[] = "'".$group['groupid']."'";	
		}
		$gn_string = implode(",",$groupnames);

		if ($menutype == 'contextmenu') {
                        $sql = "select * from tools where toolname in (select toolname from menu_tools where menuname = '$menuname' and toolname in (select toolname from tool_groups where groupid in ($gn_string)))";
                        $response = $con->query($sql);
                        $id = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['id'] = $id;
					$obj['text'] = $obj['toolname'];
					$obj['icon'] = 'fa fa-wrench';
					unset($obj['toolname']);
                                        $records['views'][$viewname]['viewobjects'][$panelname]['menus']['contextmenu'][] = $obj;
                                        $id = $id + 1;
                                }
		}

		else if ($menutype == 'toolbarmenu') {
                        $sql = "select * from tools where toolname in (select toolname from menu_tools where menuname = '$menuname' and toolname in (select toolname from tool_groups where groupid in ($gn_string)))";
                        $response = $con->query($sql);
                        $id = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['id'] = $id;
					$obj['text'] = $obj['toolname'];
					$obj['icon'] = 'fa fa-wrench';
					unset($obj['toolname']);
                                        $records['views'][$viewname]['viewobjects'][$panelname]['menus']['toolbarmenu'][] = $obj;
                                        $id = $id + 1;
                                }
                }
                return $records;
	}

	private function GetDataSet($records,$viewname,$panelname,$setname,$con) {

		if (strlen($setname) > 0) {
                $sql = "select * from dataset where setname = '$setname'";
                $response = $con->query($sql);
                $recid = 1;
                while ($obj = $response->fetch_assoc())
                        {
                                $obj['recid'] = $recid;
                                $records['views'][$viewname]['viewobjects'][$panelname]['dataset'] = $obj;
                                $recid = $recid + 1;
                        }
		}
                return $records;
	}

	private function GetConnection($records,$viewname,$panelname,$con_name,$con) {

                $sql = "select * from ds_conn where connectionname = '$con_name'";
                $response = $con->query($sql);
                $recid = 1;
                while ($obj = $response->fetch_assoc())
                        {
                                $obj['recid'] = $recid;
                                $records['views'][$viewname]['viewobjects'][$panelname]['connection'] = $obj;
                                $recid = $recid + 1;
                        }
                return $records;
        }

	private function GetViewData($records,$viewname,$panelname,$con_type,$con) {
	
		if ($con_type == 'REST') {

		$url = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['url'];
		$headers = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['headers'];
		$username = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['username'];
		$password = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['password'];
		
		//$headers = explode(",",$headers);

		$viewdata = $this->CallRESTAPI($url, $headers, $username, $password, false);
		$viewdata = strip_tags($viewdata);
		$records['views'][$viewname]['viewobjects'][$panelname]['viewdata'] = json_decode($viewdata);
		
		}

		if ($con_type == 'MySQL') {

                $username = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['username'];
                $password = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['password'];
                $host = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['host'];
                $database = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['database'];
                $port = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['port'];
                $query = $records['views'][$viewname]['viewobjects'][$panelname]['dataset']['query'];

                //$headers = explode(",",$headers);
                $viewdata = $this->GetMySQLData($username, $password, $host, $port, $database, $query);
                $records['views'][$viewname]['viewobjects'][$panelname]['viewdata'] = json_decode($viewdata);
                }
	
	        if ($con_type == 'PostgreSQL') {

                $username = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['username'];
                $password = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['password'];
                $host = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['host'];
                $database = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['database'];
                $port = $records['views'][$viewname]['viewobjects'][$panelname]['connection']['port'];
                $query = $records['views'][$viewname]['viewobjects'][$panelname]['dataset']['query'];

                //$headers = explode(",",$headers);
                $viewdata = $this->GetPGSQLData($username, $password, $host, $port, $database, $query);
                $records['views'][$viewname]['viewobjects'][$panelname]['viewdata'] = json_decode($viewdata);
                }

                return $records;
        }

	private function GetMySQLData($username, $password, $host, $port, $database, $query) {


		$dbconn = new mysqli($host, $username, $password, $database, $port);
		$response = $dbconn->query($query);

		$records = array();
                $rows = array();
                $recid = 1;

                while ($obj = $response->fetch_assoc())
                        {
                                $obj['recid'] = $recid;
                                $rows[] = $obj;
                                $recid = $recid + 1;
                        }

		$records['total'] = count($rows);
                $records['records'] = $rows;
                $jrows = json_encode($records['records']);
                return $jrows;

		$dbconn->disconnect();
	
	}

	private function GetPGSQLData($username, $password, $host, $port, $database, $query) {

		$dbconn = pg_connect("host=$host port=$port dbname=$database user=$username password=$password");
		$result = pg_query($dbconn,"$query");

		$records = array();
                $rows = array();
                $recid = 1;

		while($obj = pg_fetch_assoc($result)){
				$this->l->varErrorLog('PG ROW....');
				$this->l->varErrorLog($obj);
                                $obj['recid'] = $recid;
                                $rows[] = $obj;
                                $recid = $recid + 1;
		}
		$records['total'] = count($rows);
                $records['records'] = $rows;
                $jrows = json_encode($records['records']);
                return $jrows;
	}

        private function FormatData ($records,$viewname,$panel,$gridcolumns,$reststartproperty,$format,$con) {
			
			
			
			$viewdata = $records['views'][$viewname]['viewobjects'][$panel]['viewdata'];
			$gridrecords = array();
			$columns = array(); 

			foreach ($gridcolumns as $gc) {

				$this->l->varErrorLog("FIELD IS ".$gc->field);
				$columns[] = $gc->field;
			}

			//If you came from REST, we need the array that represents the grid data
			if (strlen($reststartproperty) > 0) {
				$recorddata = $viewdata->{$reststartproperty};
			} else { 
				$recorddata = $viewdata;
			}
			$count = 1;

			//Get the data that we need based on the grid cols we laid out
			foreach ($recorddata as $recobj) {
				$newobj = new StdClass();		
				$newobj->recid = $count;
				foreach ($columns as $c) {
					$newobj->{$c} = $recobj->{$c};			
					if (isset($format->{$c})) {
						if (is_array($format->{$c})) {
						//we are making color changes
							foreach ($format->{$c} as $style) {
								if (isset($style->{$recobj->{$c}})) {
								$newobj->w2ui->style = $style->{$recobj->{$c}};
								}
							}		
						} else {
						//see what function to call, right now should just be sec or millisec to date
							$function = $format->{$c};
							if ($function == 'millisecondsToDate') {
							$newobj->{$c} = $newobj->{$c} / 1000;
							$newobj->{$c} = date('Y/m/d H:i:s', $newobj->{$c});
							}
							if ($function == 'secondsToDate') {
							$newobj->{$c} = date('Y/m/d H:i:s', $newobj->{$c});
							}
						}
					}
				}
				
				$total = count((array)$newobj);
				$gridrecords[] = $newobj;
				$count++;
			}

			$records['views'][$viewname]['viewobjects'][$panel]['gridrecords'] = $gridrecords;
                        return $records;
        }


	private function CallRESTAPI($url, $headers, $username, $password , $method, $data=false)
	{
		$curl = curl_init();

		$method = 'GET';

		switch ($method)
		{
		    case "POST":
			curl_setopt($curl, CURLOPT_POST, 1);

			if ($data)
			    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			break;
		    case "PUT":
			curl_setopt($curl, CURLOPT_PUT, 1);
			break;
		    default:
			if ($data)
			    $url = sprintf("%s?%s", $url, http_build_query($data));
		}

		// Optional Authentication:
		curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		curl_setopt($curl, CURLOPT_USERPWD, "$username:$password");

		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

		curl_setopt($curl, CURLOPT_HTTPHEADER, array($headers));

		$result = curl_exec($curl);
		curl_close($curl);
		return $result;
		}
	
	}
