<?php

require_once __DIR__.'/../utils/Log.php';

Class GetCSV {

        private $l;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function GetOperation($action, $filepath, $chartdscolx, $chartdscoly, $chartdscolz)
        {
                if ($action == 'getchartdata') {
                        $data = $this->GetCSVChartData($filepath, $chartdscolx, $chartdscoly, $chartdscolz);
			return $data;
                } 
                if ($action == 'getgriddata' || $action == 'refreshgriddata') {
                        $data = $this->GetCSVGridData($action, $filepath);
			return $data;
                } 
        }

	private function GetCSVChartData($filepath, $chartdscolx, $chartdscoly, $chartdscolz) {

		$csvdata = array_map('str_getcsv', file("$filepath"));

		$chartinfo = array();
                $chartinfo['x'] = array();
                $chartinfo['y'] = array();
                $chartinfo['z'] = array();

                foreach ($csvdata as $datarow)
                {
                        if (isset($datarow[$chartdscolx])) {
                        array_push($chartinfo['x'], $datarow[$chartdscolx]);
                        }
                        if (isset($datarow[$chartdscoly])) {
                        array_push($chartinfo['y'], $datarow[$chartdscoly]);
                        }
                        if (isset($datarow[$chartdscolz])){
                        array_push($chartinfo['z'], $datarow[$chartdscolz]);
                        }
                }

                return $chartinfo;

        }


	private function GetCSVGridData($action, $filepath) {

		$csvdata = array_map('str_getcsv', file("$filepath"));
		$records = array();
                $rows = array();
                $recid = 1;

                foreach ($csvdata as $datarow)
                        {
			$x = 1;		
				$obj = array();
                                $obj['recid'] = $recid;
				foreach ($datarow as $field){
					$fieldname = 'field'.$x;
					$obj[$fieldname] = $field;
					$x = $x + 1;					
				}
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
                }


        }


}
