<?php

require_once 'Settings.php';
require_once __DIR__.'/../utils/Log.php';

Class Dataset {

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

        public function DatasetOperation($action, $params, $con)
        {
                if ($action == 'save') {
                        $this->CreateUpdate($params, $con);
                } else if ($action == 'get') {
                        $this->Read($params, $con);
                } else if ($action == 'delete') {
                        $this->Delete($params, $con);
                }
        }

        private function CreateUpdate($params, $con)
        {
                $this->l->varErrorLog("DatasetCreateUpdate: New Params are");
		$this->l->varErrorLog($params);

                $setname = $params['setname'];
                $connectionname = $params['connectionname'];
                $query = isset($params['query']) ? $params['query'] : '';

                $sql = "replace into dataset (`setname`, `connectionname`, `query`) values (?, ?, ?)";

                $stmt = $con->prepare($sql);
                $stmt->bind_param('sss', $setname, $connectionname, $query);
                $stmt->execute();

                $this->l->varErrorLog("DatasetCreateUpdate DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($stmt->error);
                $this->l->varErrorLog($con->error);

		$params = array();
                $this->Read($params, $con);
        }

        private function Read($params, $con) {

                //$this->l->varErrorLog("DatasetRead DB PARAMS: ");
                //$this->l->varErrorLog($params);

                $sql = '';
                $setname = isset($params->setname) ? $params->setname : (isset($params['setname']) ? $params['setname'] : 'empty');

                if ($setname === 'empty') {
                $sql = "select * from dataset";
                } else {
                $sql = "select * from dataset where setname = '$setname'";
                }

                $response = $con->query($sql);

                //$this->l->varErrorLog("DatasetRead DB Error: ");
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

        private function Delete($params, $con)
        {
                $this->l->varErrorLog("Dataset Delete Params");
                $this->l->varErrorLog($params);

                $setname = $params[0]->setname ? $params[0]->setname : ($params[0]['setname'] ? $params[0]['setname'] : 'empty');
                if (strpos($setname, '(') !== false) {
                        $sql = "delete from dataset where setname in $setname";
                        $stmt = $con->prepare($sql);
                } else {
                        $sql = "delete from dataset where setname = ?";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param('s', $setname);
                }
                $this->l->varErrorLog("Executing statement $sql");
                $stmt->execute();

                $this->l->varErrorLog("Dataset DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($con->error);
                $this->l->varErrorLog($stmt->error);

		$params = array();
                $this->Read($params, $con);
        }
}


