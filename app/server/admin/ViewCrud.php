<?php

require_once 'Settings.php';
require_once __DIR__.'/../utils/Log.php';

Class Views {

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

        public function ViewOperation($action, $params, $con)
        {
                if ($action == 'save') {
                        $this->CreateUpdate($params, $con);
                } else if ($action == 'get') {
                        $this->Read($params, $con);
                } else if ($action == 'getgroups') {
                        $this->ReadGroups($params, $con);
                } else if ($action == 'getusersviews') {
                        $this->GetUsersViews($params, $con);
                } else if ($action == 'delete') {
                        $this->Delete($params, $con);
                }
        }

        private function CreateUpdate($params, $con)
        {

                $nocviewname = $params['nocviewname'];
                $title = isset($params['title']) ? $params['title'] : '';
                $groups = isset($params['groups']) ? $params['groups'] : '';
                $toppanel = isset($params['toppanel']) ? $params['toppanel'] : '';
                $leftpanel = isset($params['leftpanel']) ? $params['leftpanel'] : '';
                $mainpanel = isset($params['mainpanel']) ? $params['mainpanel'] : '';
                $previewpanel = isset($params['previewpanel']) ? $params['previewpanel'] : '';
                $rightpanel = isset($params['rightpanel']) ? $params['rightpanel'] : '';
                $bottompanel = isset($params['bottompanel']) ? $params['bottompanel'] : '';
                $topsize = isset($params['topsize']) ? $params['topsize'] : '';
                $leftsize = isset($params['leftsize']) ? $params['leftsize'] : '';
                $mainsize = isset($params['mainsize']) ? $params['mainsize'] : '';
                $previewsize = isset($params['previewsize']) ? $params['previewsize'] : '';
                $rightsize = isset($params['rightsize']) ? $params['rightsize'] : '';
                $bottomsize = isset($params['bottomsize']) ? $params['bottomsize'] : '';
                $canvasname = isset($params['canvasname']) ? $params['canvasname'] : '';

                $sql = "replace into nocviews (`nocviewname`, `title`, `toppanel`, `leftpanel`, `mainpanel`, `previewpanel`, `rightpanel`, `bottompanel`, `topsize`, `leftsize`, `mainsize`, `previewsize`, `rightsize`, `bottomsize`, `canvasname`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,?)";

                $stmt = $con->prepare($sql);
                $stmt->bind_param('sssssssssssssss', $nocviewname, $title, $toppanel, $leftpanel, $mainpanel, $previewpanel, $rightpanel, $bottompanel, $topsize, $leftsize, $mainsize, $previewsize, $rightsize, $bottomsize, $canvasname);
                $stmt->execute();


                $sql = "delete from  nocview_groups where `nocviewname` = ?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('s', $nocviewname);
                $stmt->execute();

                foreach ($groups as $group) {

                $groupid = $group['id'];
                $sql = "insert into nocview_groups (`nocviewname`,`groupid`) values (?, ?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param('ss', $nocviewname, $groupid);
                $stmt->execute();

                }

		$params = array();
                $this->Read($params, $con);
        }

        private function Read($params, $con) {
                $sql = '';
                $nocviewname = isset($params->nocviewname) ? $params->nocviewname : (isset($params['nocviewname']) ? $params['nocviewname'] : 'empty');
                if ($nocviewname === 'empty') {
                $sql = "select * from nocviews";
                } else {
                $sql = "select * from nocviews where nocviewname = '$nocviewname'";
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

        private function GetUsersViews($params, $con) {
                $username = isset($params->username) ? $params->username : (isset($params['username']) ? $params['username'] : 'empty');
                $sql = "select * from nocviews where nocviewname in (select nocviewname from nocview_groups where groupid in (select groupid from user_groups where username='$username'))";
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

        private function ReadGroups($params, $con) {
                $sql = '';
                $nocviewname = isset($params['nocviewname']) ? $params['nocviewname'] : 'empty';
                if ($nocviewname === 'empty') {
                $sql = "select * from nocview_groups";
                } else {
                $sql = "select * from nocview_groups where nocviewname = '$nocviewname'";
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

		$nocviewname = $params[0]->nocviewname ? $params[0]->nocviewname : ($params[0]['nocviewname'] ? $params[0]['nocviewname'] : 'empty');
                if (strpos($nocviewname, '(') !== false) {
                        $sql = "delete from nocviews where nocviewname in $nocviewname";
                        $stmt = $con->prepare($sql);
                } else {
                        $sql = "delete from nocviews where nocviewname = ?";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param('s', $nocviewname);
                }
                $stmt->execute();


		$params = array();
                $this->Read($params, $con);
        }
}


