<?php

require_once __DIR__.'/../utils/Log.php';

Class GetJSON {

        private $l;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function GetOperation($action, $filepath, $reststartproperty, $chartdscolx, $chartdscoly, $chartdscolz, $result)
        {
                if ($action == 'getchartdata') {
                        $data = $this->GetJSONChartData($filepath, $reststartproperty, $chartdscolx, $chartdscoly, $chartdscolz);
			return $data;
                } 
                if ($action == 'getgriddata' || $action == 'refreshgriddata') {
                        $data = $this->GetJSONGridData($action, $filepath, $reststartproperty);
			return $data;
                } 
		if ($action == 'getgridrestjson' || $action == 'refreshgridrestjson') {
                        $data = $this->GetRESTJSONGridData($action, $reststartproperty, $result);
                        return $data;
                }
                if ($action == 'getchartrestjson') {
			$this->l->varErrorLog("ARE WE SENDING REST JSON CHART DATA???");
                        $data = $this->GetRESTJSONChartData($reststartproperty, $result, $chartdscolx, $chartdscoly, $chartdscolz);
                        return $data;
                }
        }

	private function GetJSONChartData($filepath, $reststartproperty, $chartdscolx, $chartdscoly, $chartdscolz) {
		$jsondata = json_decode(file_get_contents("$filepath"));
		if (isset($reststartproperty) && strlen($reststartproperty) > 0) {
		$jsondata = $jsondata->{$reststartproperty};
		}
		$chartinfo = array();
                $chartinfo['x'] = array();
                $chartinfo['y'] = array();
                $chartinfo['z'] = array();

		if (is_array($jsondata)) {
			foreach ($jsondata as $datarow) {
				if (isset($datarow->{$chartdscolx})) {
				array_push($chartinfo['x'], $datarow->{$chartdscolx});
				}
				if (isset($datarow->{$chartdscoly})) {
				array_push($chartinfo['y'], $datarow->{$chartdscoly});
				}
				if (isset($datarow->{$chartdscolz})){
				array_push($chartinfo['z'], $datarow->{$chartdscolz});
				}
			}
		} else {

			array_push($chartinfo['x'], $jsondata->{$chartdscolx});

		}
                return $chartinfo;
        }
        private function GetRESTJSONChartData($reststartproperty, $result, $chartdscolx, $chartdscoly, $chartdscolz) {

		$this->l->varErrorLog("REST JSON CHART PROPS ARE");
		$this->l->varErrorLog($reststartproperty);
		$this->l->varErrorLog($chartdscolx);
		$this->l->varErrorLog($chartdscoly);
		$this->l->varErrorLog($chartdscolz);
		$this->l->varErrorLog($result);


                $jsondata = json_decode($result);
                if (isset($reststartproperty) && strlen($reststartproperty) > 0) {
                $jsondata = $jsondata->{$reststartproperty};
                }
                $chartinfo = array();
                $chartinfo['x'] = array();
                $chartinfo['y'] = array();
                $chartinfo['z'] = array();

                if (is_array($jsondata)) {
                        foreach ($jsondata as $datarow) {
                                if (isset($datarow->{$chartdscolx})) {
                                array_push($chartinfo['x'], $datarow->{$chartdscolx});
                                }
                                if (isset($datarow->{$chartdscoly})) {
                                array_push($chartinfo['y'], $datarow->{$chartdscoly});
                                }
                                if (isset($datarow->{$chartdscolz})){
                                array_push($chartinfo['z'], $datarow->{$chartdscolz});
                                }
                        }
                } else {

                        array_push($chartinfo['x'], $jsondata->{$chartdscolx});

                }
                return $chartinfo;
        }


	private function GetJSONGridData($action, $filepath, $reststartproperty) {
		$jsondata = json_decode(file_get_contents($filepath));
		if (isset($reststartproperty)) {
		$jsondata = $jsondata->{$reststartproperty};
		}
		$records = array();
                $rows = array();
                $recid = 1;
                foreach ($jsondata as $datarow) {
			$obj = array();
                        $obj['recid'] = $recid;
			foreach ($datarow as $dk=>$dv){
				$obj[$dk] = $dv;
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

        private function GetRESTJSONGridData($action, $reststartproperty, $results) {

                $jsondata = json_decode($results);
                if (isset($reststartproperty)) {
                $jsondata = $jsondata->{$reststartproperty};
                }
                $records = array();
                $rows = array();
                $recid = 1;
                foreach ($jsondata as $datarow) {
                        $obj = array();
                        $obj['recid'] = $recid;
                        foreach ($datarow as $dk=>$dv){
                                $obj[$dk] = $dv;
                        }
                        $rows[] = $obj;
                        $recid = $recid + 1;
                }
                $records['total'] = count($rows);
                $records['records'] = $rows;
                $jrows = json_encode($records['records']);

                if ($action == 'refreshgridrestjson') {
                header('Content-Type: application/json');
                echo $jrows;
                } else {
                return $jrows;
                }
        }


}
