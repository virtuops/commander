<?php

require_once 'Settings.php';
require_once __DIR__.'/../utils/Log.php';

Class Tools {

        private $globalconf;
        private $con;
        private $l;
        private $s;

        public function __construct()
        {
                $this->s = new Settings();
                $this->l = new Log();
                $settings = $this->s->getSettings();
                $host = $settings['dbhost'];
                $username = $settings['dbuser'];
                $password = $settings['dbpass'];
                $dbname = $settings['dbname'];
                $port = $settings['dbport'];

//                $this->l->varErrorLog("DB Settings $host $username $password $dbname $port");
//                $con = new mysqli($host, $username, $password, $dbname, $port);


        }

        public function ToolsOperation($action, $params, $con)
        {
                if ($action == 'save') {
                        $this->CreateUpdate($params, $con);
                } else if ($action == 'get') {
                        $this->Read($params, $con);
                } else if ($action == 'getgroups') {
                        $this->ReadGroups($params, $con);
                } else if ($action == 'delete') {
                        $this->Delete($params, $con);
                }
        }

        private function CreateUpdate($params, $con)
        {
                $this->l->varErrorLog("ToolCreateUpdate: New Params are");
		$this->l->varErrorLog($params);

                $toolname = $params['toolname'];
                $groups = $params['groups'];
                $program = isset($params['program']) ? $params['program'] : '';
                $launchurl = isset($params['launchurl']) ? $params['launchurl'] : '';
                $toolfields = isset($params['toolfields']) ? $params['toolfields'] : '';
                $everyrow = isset($params['everyrow']['text']) ? $params['everyrow']['text'] : '';
                $tooltype = isset($params['tooltype']['text']) ? $params['tooltype']['text'] : '';

                $sql = "replace into tools (`toolname`, `program`, `launchurl`, `everyrow`, `tooltype`, `toolfields`) values (?, ?, ?, ?, ?, ?)";

                $stmt = $con->prepare($sql);
                $stmt->bind_param('ssssss', $toolname, $program, $launchurl, $everyrow, $tooltype, $toolfields);
                $stmt->execute();

                $this->l->varErrorLog("ToolCreateUpdate DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($stmt->error);
                $this->l->varErrorLog($con->error);

		$sql = "delete from  tool_groups where `toolname` = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('s', $toolname);
                $stmt->execute();

                foreach ($groups as $group) {

                $groupid = $group['id'];
                $sql = "insert into tool_groups (`toolname`,`groupid`) values (?, ?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('ss', $toolname, $groupid);
                $stmt->execute();

                }


		$params = array();
                $this->Read($params, $con);
        }

        private function Read($params, $con) {

                //$this->l->varErrorLog("ToolRead DB PARAMS: ");
                //$this->l->varErrorLog($params);

                $sql = '';
                $toolname = isset($params->toolname) ? $params->toolname : (isset($params['toolname']) ? $params['toolname'] : 'empty');

                if ($toolname === 'empty') {
                $sql = "select * from tools";
                } else {
                $sql = "select * from tools where toolname = '$toolname'";
                }

                $response = $con->query($sql);

                //$this->l->varErrorLog("ToolRead DB Error: ");
                //$this->l->varErrorLog($con->error);

                $records = array();
                $rows = array();
                $recid = 1;

                while ($obj = $response->fetch_assoc())
                        {
                                $obj['recid'] = $recid;
                                $rows[] = $obj;
                                $recid = $recid + 1;
                        }

                //$this->l->varErrorLog("Returning:");
                $records['total'] = count($rows);
                $records['records'] = $rows;
                $jrows = json_encode($records);
                //$this->l->varErrorLog($jrows);
                header('Content-Type: application/json');
                echo $jrows;

        }

	private function ReadGroups($params, $con) {
                $sql = '';
                $toolname = isset($params['toolname']) ? $params['toolname'] : 'empty';
                if ($toolname === 'empty') {
                $sql = "select * from tool_groups";
                } else {
                $sql = "select * from tool_groups where toolname = '$toolname'";
                }
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

                $records['total'] = count($rows);
                $records['records'] = $rows;
                $jrows = json_encode($records);
                header('Content-Type: application/json');
                echo $jrows;
        }

        private function Delete($params, $con)
        {
                $this->l->varErrorLog("Tool Delete Params");
                $this->l->varErrorLog($params);

                $toolname = $params[0]->toolname ? $params[0]->toolname : ($params[0]['toolname'] ? $params[0]['toolname'] : 'empty');
                if (strpos($toolname, '(') !== false) {
                        $sql = "delete from tools where toolname in $toolname";
                        $stmt = $con->prepare($sql);
                } else {
                        $sql = "delete from tools where toolname = ?";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param('s', $toolname);
                }
                $this->l->varErrorLog("Executing statement $sql");
                $stmt->execute();

                $this->l->varErrorLog("Tool DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($con->error);
                $this->l->varErrorLog($stmt->error);

		$params = array();
                $this->Read($params, $con);
        }
}
