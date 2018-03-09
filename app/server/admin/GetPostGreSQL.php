<?php

require_once __DIR__.'/../utils/Log.php';

Class GetPostGreSQL {

        private $l;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function GetOperation($action, $host, $port, $database, $username, $password, $query, $chartdscolx=null, $chartdscoly=null, $chartdscolz=null)
        {
                if ($action == 'getgriddata' || $action == 'refreshgriddata') {
                        $data = $this->GetPostGreSQLGridData($action, $host, $port, $database, $username, $password, $query);
			return $data;
                } 
                if ($action == 'getchartdata') {
                        $data = $this->GetPostGreSQLChartData($action, $host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz);
			return $data;
                } 
        }

	private function GetPostGreSQLGridData($action, $host, $port, $database, $username, $password, $query) {


		$dbconn = pg_connect("host=$host port=$port dbname=$database user=$username password=$password");

		if (! $dbconn) {

		$this->l->varErrorLog("THESE PGSQL PARAMS ARE NOT WOKRING: $action, $host, $port, $database, $username, $password, $query");

		}
                $response = pg_query($dbconn,"$query");

		$records = array();
                $rows = array();
                $recid = 1;

                while ($obj = pg_fetch_assoc($response))
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

	private function GetPostGreSQLChartData($action, $host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz) {

		$dbconn = pg_connect("host=$host port=$port dbname=$database user=$username password=$password");

		if (! $dbconn) {

		$this->l->varErrorLog("THESE PGSQL CHART PARAMS DO NOT WORK $host, $port, $database, $username, $password, $query, $chartdscolx, $chartdscoly, $chartdscolz");

		}
                $response = pg_query($dbconn,"$query");

                $chartinfo = array();
                $chartinfo['x'] = array();
                $chartinfo['y'] = array();
                $chartinfo['z'] = array();

                while ($obj = pg_fetch_assoc($response))
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
