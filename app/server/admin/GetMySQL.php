<?php

require_once __DIR__.'/../utils/Log.php';

Class GetMySQL {

        private $con;
        private $l;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function GetOperation($action, $host, $port, $database, $username, $password, $query, $chartdscolx=null, $chartdscoly=null, $chartdscolz=null)
        {
                if ($action == 'getgriddata' || $action == 'refreshgriddata') {
                        $data = $this->GetMySQLGridData($action, $host, $port, $database, $username, $password, $query);
			return $data;
                } 
                if ($action == 'getchartdata') {
                        $data = $this->GetMySQLChartData($host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz);
			return $data;
                } 
        }

	private function GetMySQLGridData($action, $host, $port, $database, $username, $password, $query) {


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
	
		if ($action == 'refreshgriddata') {	
		header('Content-Type: application/json');		
                echo $jrows;
		} else {
                return $jrows;
		$dbconn->disconnect();
		}
	
	}

	private function GetMySQLChartData($host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz) {

                $dbconn = new mysqli($host, $username, $password, $database, $port);
                $response = $dbconn->query($query);

                $chartinfo = array();
                $chartinfo['x'] = array();
                $chartinfo['y'] = array();
                $chartinfo['z'] = array();

                while ($obj = $response->fetch_assoc())
                        {
                                if (isset($obj[$chartdscolx])) {
                                array_push($chartinfo['x'], $obj[$chartdscolx]);
                                }
                                if (isset($obj[$chartdscoly])) {
                                array_push($chartinfo['y'], $obj[$chartdscoly]);
                                }
                                if (isset($obj[$chartdscolz])){
                                array_push($chartinfo['z'], $obj[$chartdscolz]);
                                }
                        }

                return $chartinfo;
                $dbconn->disconnect();
        }


}
