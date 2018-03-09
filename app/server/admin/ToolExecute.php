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

                $this->l->varErrorLog("ToolEXEC PARAMS: ");
                $this->l->varErrorLog($params);

                $sql = '';
                $toolprogram = isset($params->toolprogram) ? $params->toolprogram : (isset($params['toolprogram']) ? $params['toolprogram'] : 'empty');
                $selrecords = isset($params->selrecords) ? $params->selrecords : (isset($params['selrecords']) ? $params['selrecords'] : 'empty');
                $everyrow = isset($params->everyrow) ? $params->everyrow : (isset($params['everyrow']) ? $params['everyrow'] : 'false');
                $toolfields = isset($params->toolfields) ? $params->toolfields : (isset($params['toolfields']) ? $params['toolfields'] : 'empty');

		$response = new StdClass();


                if ($toolprogram === 'empty') {
			$response->message = 'The path to the tool is empty.';
                } else if (! file_exists($toolprogram)) {
			$response->message = 'There is no tool at this location.';
                } else if (count($selrecords) === 0 && $everyrow == 'true') {
			$response->message = 'This tool requires records to process.  Please select at least one row.';
		} else if ($everyrow == 'false') {
			/*Only fire the tool once on the first row selected, even if they selected more than one*/
			if ($toolfields !== 'empty') {	
				$tf = explode(",",$toolfields);
				foreach ($selrecords as $rec) {
					$toolargs = '';
					foreach ($tf as $field) {
						 if (isset($rec[$field])) {
						 $toolargs .= " '".$rec[$field]."' ";
						 }
					}

					$toolprogram = $toolprogram." ".$toolargs;
					$response->message = `$toolprogram`;
					break;
				}
			} else {

                             $response->message = `$toolprogram`;
			}

		} else {
			/* Fire the tool on every selected row */
			$tf = explode(",",$toolfields);

			foreach ($selrecords as $rec) {
	
				foreach ($tf as $field) {
					if (isset($rec[$field])) {
					$toolargs .= " '".$rec[$field]."' ";	
					}
				}
				$toolexec = $toolprogram." ".$toolargs;
				$response->message = `$toolexec`;
				unset($toolargs);
				unset($toolexec);
			}
			//$response->message = 'No Output Processed';

		}
			$jrows = json_encode($response);
			header('Content-Type: application/json');
			echo $jrows;

        }

}
