<?php

require_once 'GetMySQL.php';
require_once 'GetPostGreSQL.php';
require_once 'GetXML.php';
require_once 'GetCSV.php';
require_once 'GetJSON.php';
require_once 'GetRESTXML.php';
require_once 'GetRESTJSON.php';

require_once __DIR__.'/../utils/Log.php';

Class GridData {

	private $mysql;
        private $postgres;
        private $xml;
        private $json;
        private $soap;
        private $restxml;
        private $restjson;
        private $csv;
        private $l;

        public function __construct()
        {
                $this->l = new Log();
		$this->mysql = new GetMySQL();
		$this->postgres = new GetPostGreSQL();
		$this->restxml = new GetRESTXML();
		$this->restjson = new GetRESTJSON();
		$this->xml = new GetXML();
		$this->json = new GetJSON();
		$this->csv = new GetCSV();


        }


	public function GetOperation($action, $params, $con) {



		if ($action == 'getparams') {
                        $host = $params['dbhost'];
                        $username = $params['dbuser'];
                        $password = $params['dbpass'];
                        $database = $params['dbname'];
                        $port = $params['dbport'];

			$objname = $params['objname'];
			$gridparams = $this->GetParams($objname, $host, $username, $password, $database, $port);
			return $gridparams;
		}
		if ($action == 'getcontextmenu' || $action == 'gettoolbarmenu') {
                        $host = $params['dbhost'];
                        $username = $params['dbuser'];
                        $nhuser = $params['nhuser'];
                        $password = $params['dbpass'];
                        $database = $params['dbname'];
                        $port = $params['dbport'];
			if ($action == 'getcontextmenu') {	
			$contextmenuname = $params['contextmenu'];
			}
			if ($action == 'gettoolbarmenu'){
			$toolmenuname = $params['toolbarmenu'];
			$viewmenuname = $params['viewmenu'];
			}
			$menu = $this->GetMenu($action, $contextmenuname, $toolmenuname, $viewmenuname, $nhuser, $host, $username, $password, $database, $port);
			return $menu;
		}
		if ($action == 'getgriddata' || $action == 'refreshgriddata') {
                        $host = $params['host'];
                        $username = $params['username'];
                        $reststartproperty = strlen($params['reststartproperty']) > 0 ? $params['reststartproperty'] : null;
                        $password = $params['password'];
                        $database = $params['database'];
                        $port = $params['port'];
			$connectiontype = $params['connectiontype'];
                        $url = $params['url'];
			$filepath = $params['fileloc'];
                        $query = $params['query'];
			$griddata = $this->GetData($action, $connectiontype, $url, $host, $port, $database, $username, $password, $query, $filepath, $reststartproperty);
			return $griddata;
		}

	}

        private function GetGroups($nhuser, $host, $username, $password, $database, $port) {

		$con = new mysqli($host, $username, $password, $database, $port);
                $sql = "select groupid from user_groups where username = '$nhuser'";
		$response = $con->query($sql);
                $rows = array();
                $recid = 1;
                while ($obj = $response->fetch_assoc())
                        {
                                $obj['recid'] = $recid;
                                $rows[] = $obj;
                                $recid = $recid + 1;
                        }
		$con->close();
                return $rows;
        }

	private function GetMenu($menutype, $contextmenuname, $toolmenuname, $viewmenuname, $nhuser, $host, $username, $password, $database, $port) {

                $groups = $this->GetGroups($nhuser, $host, $username, $password, $database, $port);
		$con = new mysqli($host, $username, $password, $database, $port);


                $groupnames = array();
		$menu = array();
		$records = array();

                foreach ($groups as $group){
                        $groupnames[] = "'".$group['groupid']."'";
                }
                $gn_string = implode(",",$groupnames);

                if (isset($contextmenuname) && strlen($contextmenuname) > 0) {
			
                        $sql = "select * from tools where toolname in (select toolname from menu_tools where menuname = '$contextmenuname' and toolname in (select toolname from tool_groups where groupid in ($gn_string)))";
                        $response = $con->query($sql);
                        $id = 1;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['id'] = $id;
					$obj['menutype'] = 'Context';
                                        $obj['text'] = $obj['toolname'];
                                        $obj['img'] = 'toolsicon';
                                        unset($obj['toolname']);
					$menu[] = $obj;
                                        $id = $id + 1;
                                }
                }

                if (isset($toolmenuname) && strlen($toolmenuname) > 0) {
			$toolmenu = array("type"=>"menu", "id" =>"item1", "img"=>"toolsicon","text"=>"Select Tool","selected"=>"id1","items"=>array()); 
				
                        $sql = "select * from tools where toolname in (select toolname from menu_tools where menuname = '$toolmenuname' and toolname in (select toolname from tool_groups where groupid in ($gn_string)))";
			
                        $response = $con->query($sql);
                        $id = 2;
			array_push($toolmenu['items'],array("id" => "id1", "text"=> "Select Tool", "img"=> "toolsicon"));
                        while ($obj = $response->fetch_assoc())
                                {
					$this->l->varErrorLog('Getting the next tool');
					$this->l->varErrorLog($obj);
		
                                        $obj['id'] = 'id'.$id;
                                        $obj['text'] = $obj['toolname'];
					$obj['menutype'] = 'Tools';
                                        $obj['img'] = 'toolsicon';
                                        $obj['type'] = 'button';
                                        unset($obj['toolname']);
					array_push($toolmenu['items'], $obj);
                                        $id = $id + 1;
                                }
			array_push($menu, $toolmenu);
                }

                if (isset($viewmenuname) && strlen($viewmenuname) > 0) {
			$viewmenu = array("type"=>"menu", "id" =>"item2", "img" => "viewsicon","text" => "Select View","selected"=>"id1","items" => array()); 
				
			$sql = "select objname from viewobjects where objname in (select objname from menu_views where menuname = '$viewmenuname')";	
                        $response = $con->query($sql);
                        $id = 2;
			array_push($viewmenu['items'],array("id" => "id1", "text"=> "Select View", "img"=> "viewsicon"));
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['id'] = 'id'.$id;
                                        $obj['text'] = $obj['objname'];
					$obj['menutype'] = 'Views';
					$obj['tooltype'] = 'View';
                                        $obj['img'] = 'viewsicon';
                                        $obj['type'] = 'button';
                                        unset($obj['objname']);
					array_push($viewmenu["items"], $obj);
                                        $id = $id + 1;
                                }
			array_push($menu, $viewmenu);
                }

                return $menu;
	}


	private function GetParams($objname, $host, $username, $password, $database, $port){
	
		$dbconn = new mysqli($host, $username, $password, $database, $port);

		$sql = "select vo.*, d.*, c.* from viewobjects vo left join dataset d on vo.setname = d.setname left join ds_conn c on d.connectionname = c.connectionname where vo.objname='$objname'";

		$response = $dbconn->query($sql);
		$gridparams = $response->fetch_assoc();
		return $gridparams;
	}

        public function GetData($action, $connectiontype, $url, $host, $port, $database, $username, $password, $query, $filepath,$reststartproperty=null)
        {
                if ($connectiontype == 'MySQL') {
                        $gridinfo = $this->mysql->GetOperation($action, $host, $port, $database, $username, $password, $query);
			return $gridinfo;
                } 
		if ($connectiontype == 'PostgreSQL') {
                        $gridinfo = $this->postgres->GetOperation($action, $host, $port, $database, $username, $password, $query);
			return $gridinfo;
		}
		if ($connectiontype == 'RESTXML') {
			$xml = $this->xml;
			$gridinfo = $this->restxml->GetOperation($action, $url, $headers, $username, $password, $method, $data=false, $reststartproperty, $xml);
			return $gridinfo;

		}
		if ($connectiontype == 'RESTJSON') {
			$json = $this->json;
			$gridinfo = $this->restjson->GetOperation($action, $url, $headers, $username, $password, $method, $data=false, $reststartproperty, $json);
			return $gridinfo;
		}
		if ($connectiontype == 'CSV') {
                        $gridinfo = $this->csv->GetOperation($action, $filepath, $griddscolx, $griddscoly, $griddscolz);
                        return $gridinfo;
                }
                if ($connectiontype == 'JSON') {
                        $gridinfo = $this->json->GetOperation($action,$filepath,$reststartproperty);
                        return $gridinfo;
                }
                if ($connectiontype == 'XML') {
                        $gridinfo = $this->xml->GetOperation($action,$filepath,$reststartproperty);
                        return $gridinfo;
                }
        }
}
