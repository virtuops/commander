<?php

require_once 'Settings.php';
require_once __DIR__.'/../utils/Log.php';

Class Connection {

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

        public function ConnectionOperation($action, $params, $con)
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
                $this->l->varErrorLog("ConnectionCreateUpdate: New Params are");
		$this->l->varErrorLog($params);

                $connectionname = $params['connectionname'];
                $connectiontype = isset($params['connectiontype']) ? $params['connectiontype'] : '';
                $url = isset($params['url']) ? $params['url'] : '';
                $fileloc = isset($params['fileloc']) ? $params['fileloc'] : '';
                $username = isset($params['username']) ? $params['username'] : '';
                $password = isset($params['password']) ? $params['password'] : '';
                $host = isset($params['host']) ? $params['host'] : '';
                $port = isset($params['port']) ? (int)$params['port'] : -1;
                $description = isset($params['description']) ? $params['description'] : '';
                $headers = isset($params['headers']) ? $params['headers'] : '';
                $database = isset($params['database']) ? $params['database'] : '';

                $sql = "replace into ds_conn (`connectionname`, `connectiontype`, `username`, `password`, `host`, `port`, `url`, `fileloc`, `database`, `headers`, `description`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $con->prepare($sql);
                $stmt->bind_param('sssssisssss', $connectionname, $connectiontype, $username, $password, $host, $port, $url, $fileloc, $database, $headers, $description);
                $stmt->execute();

                $this->l->varErrorLog("ConnectionCreateUpdate DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($stmt->error);
                $this->l->varErrorLog($con->error);

		$params = array();
                $this->Read($params, $con);
        }

        private function Read($params, $con) {

                //$this->l->varErrorLog("ConnectionRead DB PARAMS: ");
                //$this->l->varErrorLog($params);

                $sql = '';
                $connectionname = isset($params->connectionname) ? $params->connectionname : (isset($params['connectionname']) ? $params['connectionname'] : 'empty');

                if ($connectionname === 'empty') {
                $sql = "select * from ds_conn";
                } else {
                $sql = "select * from ds_conn where connectionname = '$connectionname'";
                }

                $response = $con->query($sql);

                //$this->l->varErrorLog("ConnectionRead DB Error: ");
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
                $this->l->varErrorLog("Connection Delete Params");
                $this->l->varErrorLog($params);

                $connectionname = $params[0]->connectionname ? $params[0]->connectionname : ($params[0]['connectionname'] ? $params[0]['connectionname'] : 'empty');
                if (strpos($connectionname, '(') !== false) {
                        $sql = "delete from ds_conn where connectionname in $connectionname";
                        $stmt = $con->prepare($sql);
                } else {
                        $sql = "delete from ds_conn where connectionname = ?";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param('s', $connectionname);
                }
                $this->l->varErrorLog("Executing statement $sql");
                $stmt->execute();

                $this->l->varErrorLog("ConnectionDelete DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($con->error);
                $this->l->varErrorLog($stmt->error);

		$params = array();
                $this->Read($params, $con);
        }
}


