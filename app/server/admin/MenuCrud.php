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
                $menutype = $params['menutype']['text'];
		$menutools = $params['menutools'];
		$menuviews = $params['menuviews'];

                $sql = "replace into menus (`menuname`,`menutype`) values (?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('ss', $menuname, $menutype);
                $stmt->execute();

                $this->l->varErrorLog("MenuCreateUpdate DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($stmt->error);
                $this->l->varErrorLog($con->error);

		if ($menutype == 'Tools') {
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

		} else if ($menutype == 'Views') {

		$sql = "delete from  menu_views where `menuname` = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('s', $menuname);
                $stmt->execute();

                foreach ($menuviews as $view) {

                $viewname = $view['text'];
                $sql = "insert into menu_views (`menuname`,`objname`) values (?, ?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('ss', $menuname, $viewname);
                $stmt->execute();


		}

		}

		$params = array();
                $this->Read($params, $con);
        }

        private function Read($params, $con) {
                $sql = '';
                $menuname = isset($params->menuname) ? $params->menuname : (isset($params['menuname']) ? $params['menuname'] : 'empty');
                $menutype = isset($params->menutype) ? $params->menutype : (isset($params['menutype']) ? $params['menutype'] : 'empty');
		$sql = '';

                if ($menuname === 'empty' && $menutype === 'empty') {
                $sql = "select * from menus";
                } else {
			if ($menuname !== 'empty' && $menutype === 'empty') {	
                	$sql = "select * from menus where menuname = '$menuname'";
			}
			if ($menuname === 'empty' && $menutype !== 'empty') {	
                	$sql = "select * from menus where menutype = '$menutype'";
			}
			
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
                $menutype = $params['menutype'];

		if ($menutype === 'Tools') {
                $sql = "select * from menu_tools where menuname = '$menuname'";
		} else if ($menutype === 'Views') {
                $sql = "select * from menu_views where menuname = '$menuname'";
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
		$this->l->varErrorLog($records);
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
                	$menuviewsql = "delete from  menu_views where `menuname` in $menuname";
                        $stmt = $con->prepare($sql);
                        $mtstmt = $con->prepare($menutoolsql);
                        $mvstmt = $con->prepare($menuviewsql);
			$this->l->varErrorLog("Executing statement $sql");
			$stmt->execute();
			$mtstmt->execute();
			$mvstmt->execute();
			$vosql_toolbarmenu = "update viewobjects set toolbarmenu='None' where toolbarmenu in $menuname";
			$vosql_contextmenu = "update viewobjects set contextmenu = 'None' where contextmenu in $menuname";
			$votstmt = $con->prepare($vosql_toolbarmenu);
			$vocstmt = $con->prepare($vosql_contextmenu);
			$votstmt->execute();
			$vocstmt->execute();
                } else {
                        $sql = "delete from menus where menuname = ?";
                        $menutoolsql = "delete from menu_tools where menuname = ?";
                        $menuviewsql = "delete from menu_tools where menuname = ?";
                        $stmt = $con->prepare($sql);
                        $mtstmt = $con->prepare($menutoolsql);
                        $mvstmt = $con->prepare($menuviewsql);
                        $stmt->bind_param('s', $menuname);
                        $mtstmt->bind_param('s', $menuname);
                        $mvstmt->bind_param('s', $menuname);
			$this->l->varErrorLog("Executing statement $sql");
			$stmt->execute();
			$mtstmt->execute();
			$mvstmt->execute();
			$vosql_toolbarmenu = "update viewobjects set toolbarmenu='None' where toolbarmenu = ?";
			$vosql_contextmenu = "update viewobjects set contextmenu = 'None' where contextmenu = ?";
			$votstmt = $con->prepare($vosql_toolbarmenu);
			$vocstmt = $con->prepare($vosql_contextmenu);
			$votstmt->bind_param('s', $menuname);
			$vocstmt->bind_param('s', $menuname);
			$votstmt->execute();
			$vocstmt->execute();
                }


                $this->l->varErrorLog("Menu DB Error: ");
                $this->l->varErrorLog($stmt->affected_rows);
                $this->l->varErrorLog($con->error);
                $this->l->varErrorLog($stmt->error);

		$params = array();
                $this->Read($params, $con);
        }
}
