<?php

require_once __DIR__.'/../utils/Log.php';

Class GetXML {

        private $l;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function GetOperation($action, $filepath, $reststartproperty, $chartdscolx, $chartdscoly, $chartdscolz,$result)
        {

                if ($action == 'getchartdata') {
                        $data = $this->GetXMLChartData($filepath, $reststartproperty, $chartdscolx, $chartdscoly, $chartdscolz);
			return $data;
                } 
                if ($action == 'getgriddata' || $action == 'refreshgriddata') {
                        $data = $this->GetXMLGridData($action, $filepath, $reststartproperty);
			return $data;
                } 
                if ($action == 'getgridrestxml' || $action == 'refreshgridrestxml') {
			
                        $data = $this->GetRESTXMLGridData($action, $reststartproperty, $result);
			return $data;
                } 
                if ($action == 'getchartrestxml') {
                        $data = $this->GetRESTXMLChartData($reststartproperty, $result, $chartdscolx, $chartdscoly, $chartdscolz);
			return $data;
                } 
        }

	private function GetXMLChartData($filepath, $reststartproperty, $chartdscolx, $chartdscoly, $chartdscolz) {
                $xmldata = new SimpleXMLElement(file_get_contents($filepath));
                if (!isset($reststartproperty) || strlen($reststartproperty) == 0) {
                        $this->l->varErrorLog('You need to specify at least one XML property');
                        return;
                }
                $dataarray = $this->GetXMLDataArray($xmldata, $reststartproperty);
		$chartinfo = array();
                $chartinfo['x'] = array();
                $chartinfo['y'] = array();
                $chartinfo['z'] = array();



		foreach ($dataarray as $datarow) {
			if ((string)$datarow->{$chartdscolx} !== '') {
			array_push($chartinfo['x'], (string)$datarow->{$chartdscolx});
			} else if ((string)$datarow[$chartdscolx] !== '') {
			array_push($chartinfo['x'], (string)$datarow[$chartdscolx]);
			} else if ((string)$datarow->{$chartdscoly} !== '') {
			array_push($chartinfo['y'], (string)$datarow->{$chartdscoly});
			}else if ((string)$datarow[$chartdscoly] !== '') {
                        array_push($chartinfo['y'], (string)$datarow[$chartdscoly]);
			} else if ((string)$datarow->{$chartdscolz} !== ''){
			array_push($chartinfo['z'], (string)$datarow->{$chartdscolz});
			} else if ((string)$datarow[$chartdscolz] !== '') {
                        array_push($chartinfo['z'], (string)$datarow[$chartdscolz]);
                        }
		}
                return $chartinfo;
        }

        private function GetRESTXMLChartData($reststartproperty, $result, $chartdscolx, $chartdscoly, $chartdscolz) {

                $xmldata = new SimpleXMLElement($result);
                if (!isset($reststartproperty) || strlen($reststartproperty) == 0) {
                        $this->l->varErrorLog('You need to specify at least one XML property');
                        return;
                }
                $dataarray = $this->GetXMLDataArray($xmldata, $reststartproperty);
                $chartinfo = array();
                $chartinfo['x'] = array();
                $chartinfo['y'] = array();
                $chartinfo['z'] = array();

                foreach ($dataarray as $datarow) {
                        if ((string)$datarow->{$chartdscolx} !== '') {
                        array_push($chartinfo['x'], (string)$datarow->{$chartdscolx});
                        } else if ((string)$datarow[$chartdscolx] !== '') {
                        array_push($chartinfo['x'], (string)$datarow[$chartdscolx]);
                        } else if ((string)$datarow->{$chartdscoly} !== '') {
                        array_push($chartinfo['y'], (string)$datarow->{$chartdscoly});
                        } else if ((string)$datarow[$chartdscoly] !== '') {
                        array_push($chartinfo['y'], (string)$datarow[$chartdscoly]);
                        } else if ((string)$datarow->{$chartdscolz} !== ''){
                        array_push($chartinfo['z'], (string)$datarow->{$chartdscolz});
                        } else if ((string)$datarow[$chartdscolz] !== '') {
                        array_push($chartinfo['z'], (string)$datarow[$chartdscolz]);
                        }
                }
                return $chartinfo;
        }


	private function GetXMLGridData($action, $filepath, $reststartproperty) {

		$xmldata = new SimpleXMLElement(file_get_contents($filepath));

		if (!isset($reststartproperty) || strlen($reststartproperty) == 0) {
			$this->l->varErrorLog('You need to specify at least one XML property');
			return;
		}

		$records = array();
                $rows = array();
                $recid = 1;

		$dataarray = $this->GetXMLDataArray($xmldata, $reststartproperty);

                foreach ($dataarray as $datarow) {


			$obj = array();
                        $obj['recid'] = $recid;

                        foreach($datarow->attributes() as $k => $v) {
                                $obj[$k] = (string)$v;
                        }

			foreach ($datarow as $dk=>$dv){
				$obj[$dk] = (string)$datarow->{$dk};
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

	private function GetRESTXMLGridData($action, $reststartproperty, $result) {

		$xmldata = new SimpleXMLElement($result);

		if (!isset($reststartproperty) || strlen($reststartproperty) == 0) {
			$this->l->varErrorLog('You need to specify at least one XML property');
			return;
		}

		$records = array();
                $rows = array();
                $recid = 1;

		$dataarray = $this->GetXMLDataArray($xmldata, $reststartproperty);

                foreach ($dataarray as $datarow) {


			$obj = array();
                        $obj['recid'] = $recid;
		
			foreach($datarow->attributes() as $k => $v) {
				$obj[$k] = (string)$v;
			}

			foreach ($datarow as $dk=>$dv){
				$obj[$dk] = (string)$datarow->{$dk};
			}

                        $rows[] = $obj;
                        $recid = $recid + 1;

                }

                $records['total'] = count($rows);
                $records['records'] = $rows;
		
                $jrows = json_encode($records['records']);

                if ($action == 'refreshgridrestxml') {
                header('Content-Type: application/json');
                echo $jrows;
                } else {
                return $jrows;
                }


        }


	private function GetXMLDataArray($xmldata, $reststartproperty) {


	$rp = explode(",",$reststartproperty);
	$numnodes = count($rp);

        if ($numnodes === 0) {
		$this->l->varErrorLog('You need at least one node here');
        } else if ($numnodes === 1) {
                $dataarray = $xmldata->{$rp[0]};
        } else if ($numnodes === 2) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]};
        } else if ($numnodes === 3) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]};
        } else if ($numnodes === 4) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]};
        } else if ($numnodes === 5) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]};
        } else if ($numnodes === 6) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]};
        } else if ($numnodes === 7) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]};
        } else if ($numnodes === 8) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]};
        } else if ($numnodes === 9) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]};
        } else if ($numnodes === 10) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]};
        } else if ($numnodes === 11) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]};
        } else if ($numnodes === 12) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]};
        } else if ($numnodes === 13) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]}->{$rp[12]};
        } else if ($numnodes === 14) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]}->{$rp[12]}->{$rp[13]};
        } else if ($numnodes === 15) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]}->{$rp[12]}->{$rp[13]}->{$rp[14]};
        } else if ($numnodes === 16) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]}->{$rp[12]}->{$rp[13]}->{$rp[14]}->{$rp[15]};
        } else if ($numnodes === 17) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]}->{$rp[12]}->{$rp[13]}->{$rp[14]}->{$rp[15]}->{$rp[16]};
        } else if ($numnodes === 18) {
                $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]}->{$rp[12]}->{$rp[13]}->{$rp[14]}->{$rp[15]}->{$rp[16]}->{$rp[17]};
} else if ($numnodes === 19) {
        $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]}->{$rp[12]}->{$rp[13]}->{$rp[14]}->{$rp[15]}->{$rp[16]}->{$rp[17]}->{$rp[18]};
} else if ($numnodes === 20) {
        $dataarray = $xmldata->{$rp[0]}->{$rp[1]}->{$rp[2]}->{$rp[3]}->{$rp[4]}->{$rp[5]}->{$rp[6]}->{$rp[7]}->{$rp[8]}->{$rp[9]}->{$rp[10]}->{$rp[11]}->{$rp[12]}->{$rp[13]}->{$rp[14]}->{$rp[15]}->{$rp[16]}->{$rp[17]}->{$rp[18]}->{$rp[19]};
}

	return $dataarray;
	}


}
