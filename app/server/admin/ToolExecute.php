<?php

require_once __DIR__.'/../utils/Log.php';

Class ToolExecute{

        private $l;
        private $s;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function ToolExecuteOperation($action, $params, $con)
        {
                if ($action == 'firetool') {
                        $this->FireTool($params, $con);
                }
        }

        private function FireTool($params, $con) {

                $sql = '';
                $toolprogram = isset($params->toolprogram) ? $params->toolprogram : (isset($params['toolprogram']) ? $params['toolprogram'] : 'empty');
                $selrecords = isset($params->selrecords) ? $params->selrecords : (isset($params['selrecords']) ? $params['selrecords'] : 'empty');
                $outputcols = isset($params->outputcols) ? $params->outputcols : (isset($params['outputcols']) ? $params['outputcols'] : 'empty');
                $multirow = isset($params->multirow) ? $params->multirow : (isset($params['multirow']) ? $params['multirow'] : 'empty');
                $everyrow = isset($params->everyrow) ? $params->everyrow : (isset($params['everyrow']) ? $params['everyrow'] : 'false');
                $toolfields = isset($params->toolfields) ? $params->toolfields : (isset($params['toolfields']) ? $params['toolfields'] : 'empty');

		$response = new StdClass();
		$response->columns = json_decode($outputcols);


                if ($toolprogram === 'empty') {
			$response->message = 'The path to the tool is empty.';
                } else if (! file_exists($toolprogram)) {
			$response->message = 'There is no tool at this location.';
                } else if (count($selrecords) === 0 && $everyrow == 'true') {
			$response->message = 'This tool requires records to process.  Please select at least one row.';
		} else if ($everyrow == 'false') {
			/*Only fire the tool once on the first row selected, even if they selected more than one*/
			$outarray = array();
			if ($toolfields !== 'empty') {	
				$tf = explode(",",$toolfields);
				foreach ($selrecords as $rec) {
					$toolargs = '';
					foreach ($tf as $field) {
						 if (isset($rec[$field])) {
						 $toolargs .= " '".$rec[$field]."' ";
						 } else {

						 $toolargs .= " '".$field."' ";
						 }
					}

					$toolprogram = $toolprogram." ".$toolargs;
					$toolout = `$toolprogram`;
					$toolout = json_decode($toolout);

					if ($multirow == 'false') {
					array_push($outarray, $toolout);
					$response->records = $outarray;
					} else {
					$response->records = $toolout;
					}
					break;
				}
			} else {
			     $toolout = `$toolprogram`;
			     $toolout = json_decode($toolout);
			     if ($multirow == 'false') {
			     array_push($outarray, $toolout);
			     $response->records = $outarray;
			     } else {
			     $response->records = $toolout;
			     }
			}

		} else {
			/* Fire the tool on every selected row */
			$outarray = array();
			$tf = explode(",",$toolfields);
			$x = 1;
			foreach ($selrecords as $rec) {
	
				foreach ($tf as $field) {
					if (isset($rec[$field])) {
					$toolargs .= " '".$rec[$field]."' ";	
					} else {
					$toolargs .= " '".$field."' ";
					}
				}
				$toolexec = $toolprogram." ".$toolargs;
				$this->l->varErrorLog("Tool Exec Program is $toolexec");
				$toolout = json_decode(`$toolexec`);
				array_push($outarray, $toolout);
				$response->records = $outarray;
				unset($toolargs);
				unset($toolexec);
				$x++;
			}

		}
			$jrows = json_encode($response);
			header('Content-Type: application/json');
			echo $jrows;

        }

}
