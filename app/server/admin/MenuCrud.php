<?php

require_once 'Settings.php';
require_once __DIR__.'/../utils/Log.php';

Class Menus {

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

        public function MenusOperation($action, $params, $con)
        {
                if ($action == 'save') {
                        $this->CreateUpdate($params, $con);
                } else if ($action == 'get') {
                        $this->Read($params, $con);
                } else if ($action == 'getselected') {
                        $this->ReadSelected($params, $con);
                } else if ($action == 'delete') {
                        $this->Delete($params, $con);
                }
        }

        private function CreateUpdate($params, $con)
        {
                $this->l->varErrorLog("MenuCreateUpdate: New Params are");
		$this->l->varErrorLog($params);

                $menuname = $params['menuname'];
		$menutools = $params['menutools'];

                $sql = "replace into menus (`menuname`) values (?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('s', $menuname);
                $stmt->execute();

                $this->l->varErrorLog("MenuCreateUpdate DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($stmt->error);
                $this->l->varErrorLog($con->error);

                $sql = "delete from  menu_tools where `menuname` = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('s', $menuname);
                $stmt->execute();

		foreach ($menutools as $tool) {

		$toolname = $tool['text'];
                $sql = "insert into menu_tools (`menuname`,`toolname`) values (?, ?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('ss', $menuname, $toolname);
                $stmt->execute();

		}

		$params = array();
                $this->Read($params, $con);
        }

        private function Read($params, $con) {
                $sql = '';
                $menuname = isset($params->menuname) ? $params->menuname : (isset($params['menuname']) ? $params['menuname'] : 'empty');

                if ($menuname === 'empty') {
                $sql = "select * from menus";
                } else {
                $sql = "select * from menus where menuname = '$menuname'";
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
                //$this->l->varErrorLog($jrows);
                header('Content-Type: application/json');
                echo $jrows;
        }

        private function ReadSelected($params, $con) {
                $this->l->varErrorLog("Menu Selected Params");
                $this->l->varErrorLog($params);

                $sql = '';
                $menuname = $params['menuname'];

                $sql = "select * from menu_tools where menuname = '$menuname'";

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
                //$this->l->varErrorLog($jrows);
                header('Content-Type: application/json');
                echo $jrows;
        }

        private function Delete($params, $con)
        {
                $this->l->varErrorLog("Menu Delete Params");
                $this->l->varErrorLog($params);

                $menuname = $params[0]->menuname ? $params[0]->menuname : ($params[0]['menuname'] ? $params[0]['menuname'] : 'empty');
                if (strpos($menuname, '(') !== false) {
                        $sql = "delete from menus where menuname in $menuname";
                	$menutoolsql = "delete from  menu_tools where `menuname` in $menuname";
                        $stmt = $con->prepare($sql);
                        $mtstmt = $con->prepare($menutoolsql);
                } else {
                        $sql = "delete from menus where menuname = ?";
                        $menutoolsql = "delete from menu_toolss where menuname = ?";
                        $stmt = $con->prepare($sql);
                        $mtstmt = $con->prepare($menutoolsql);
                        $stmt->bind_param('s', $menuname);
                        $mtstmt->bind_param('s', $menuname);
                }
                $this->l->varErrorLog("Executing statement $sql");
                $stmt->execute();
                $mtstmt->execute();

                $this->l->varErrorLog("Menu DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($con->error);
                $this->l->varErrorLog($stmt->error);

		$params = array();
                $this->Read($params, $con);
        }
}
