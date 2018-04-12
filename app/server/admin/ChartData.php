<?php

require_once 'GetMySQL.php';
require_once 'GetPostGreSQL.php';
require_once 'GetXML.php';
require_once 'GetCSV.php';
require_once 'GetJSON.php';
require_once 'GetRESTXML.php';
require_once 'GetRESTJSON.php';

require_once __DIR__.'/../utils/Log.php';

Class ChartData {

	private $mysql;
        private $postgres;
        private $xml;
        private $restxml;
        private $restjson;
        private $json;
        private $soap;
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
			$charttype = $params['charttype'];
			$objname = $params['objname'];
			$host = $params['host'];
			$username = $params['username'];
			$password = $params['password'];
			$database = $params['database'];
			$port = $params['port'];

			$chartparams = $this->GetParams($charttype, $objname, $host, $username, $password, $database, $port);
			return $chartparams;
		}
		if ($action == 'gettoolbarmenu') {
                        $nhuser = $params['username'];
                        $menuname = $params['toolbarmenu'];
                        $menu = $this->GetMenu($action, $menuname, $nhuser, $con);
                        return $menu;

                }
		if ($action == 'getchartdata') {
			$connectiontype = $params['connectiontype'];
                        $url = $params['url'];
                        $host = $params['host'];
			$headers = $params['headers'];
                        $port = $params['port'];
                        $database = $params['database'];
                        $username = $params['username'];
                        $password = $params['password'];
			$filepath = $params['fileloc'];
                        $query = $params['query'];
                        $reststartproperty = $params['reststartproperty'];
                        $chartdscolx = $params['chartdscolx'];
                        $chartdscoly = $params['chartdscoly'];
                        $chartdscolz = $params['chartdscolz'];
	
			$chartdata = $this->GetData($connectiontype, $url, $host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz, $filepath, $reststartproperty, $headers);
			return $chartdata;
		}

	}

        private function GetMenu($menutype, $menuname, $nhuser, $con) {

                $groups = $this->GetGroups($nhuser, $con);

                $groupnames = array();
                $menu = array();

                foreach ($groups as $group){
                        $groupnames[] = "'".$group['groupid']."'";
                }
                $gn_string = implode(",",$groupnames);

                if ($menutype == 'gettoolbarmenu') {
                        $sql = "select * from tools where toolname in (select toolname from menu_tools where menuname = '$menuname' and toolname in (select toolname from tool_groups where groupid in ($gn_string)))";
                        $response = $con->query($sql);
                        $id = 2;
                        while ($obj = $response->fetch_assoc())
                                {
                                        $obj['id'] = $id;
                                        $obj['text'] = $obj['toolname'];
                                        $obj['img'] = 'toolsicon';
                                        $obj['type'] = 'button';
                                        unset($obj['toolname']);
                                        $menu[] = $obj;
                                        $id = $id + 1;
                                }
			$this->l->varErrorLog($menu);
                }
		$menu = json_encode($menu);
		header('Content-Type: application/json');
                echo $menu;
		
        }

        private function GetGroups($nhuser, $con) {

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
                return $rows;
        }


	private function GetParams($charttype, $objname, $host, $username, $password, $database, $port){
	
		$dbconn = new mysqli($host, $username, $password, $database, $port);

		$sql = "select vo.*, d.*, c.* from viewobjects vo left join dataset d on vo.setname = d.setname left join ds_conn c on d.connectionname = c.connectionname where vo.objname='$objname'";

		$response = $dbconn->query($sql);
		$chartparams = $response->fetch_assoc();
		return $chartparams;
	}

        public function GetData($connectiontype, $url, $host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz, $filepath, $reststartproperty, $headers)
        {
                if ($connectiontype == 'MySQL') {
                        $chartinfo = $this->mysql->GetOperation('getchartdata', $host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz);
			return $chartinfo;
                } 
		if ($connectiontype == 'PostgreSQL') {
                        $chartinfo = $this->postgres->GetOperation('getchartdata', $host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz);
			return $chartinfo;
		}
		if ($connectiontype == 'CSV') {
                        $chartinfo = $this->csv->GetOperation('getchartdata', $filepath, $chartdscolx, $chartdscoly, $chartdscolz);
                        return $chartinfo;
                }
                if ($connectiontype == 'JSON') {
                        $chartinfo = $this->json->GetOperation('getchartdata', $filepath, $reststartproperty, $chartdscolx, $chartdscoly, $chartdscolz);
                        return $chartinfo;
                }
                if ($connectiontype == 'XML') {
                        $chartinfo = $this->xml->GetOperation('getchartdata', $filepath, $reststartproperty, $chartdscolx, $chartdscoly, $chartdscolz);
                        return $chartinfo;
                }
                if ($connectiontype == 'RESTXML') {
			$xml = $this->xml;
                        $chartinfo = $this->restxml->GetOperation('getchartdata', $url, $headers, $username, $password, $method, $data=false, $reststartproperty, $xml, $chartdscolx, $chartdscoly, $chartdscolz);
                        return $chartinfo;
                }
                if ($connectiontype == 'RESTJSON') {
			$json = $this->json;
                        $chartinfo = $this->restjson->GetOperation('getchartdata', $url, $headers, $username, $password, $method, $data=false, $reststartproperty, $json, $chartdscolx, $chartdscoly, $chartdscolz);
                        return $chartinfo;
                }
        }
}
