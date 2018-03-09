<?php

require_once __DIR__.'/../admin/ConnectionCrud.php';
require_once __DIR__.'/../admin/DataSetCrud.php';
require_once __DIR__.'/../admin/ViewObjectCrud.php';
require_once __DIR__.'/../admin/ViewCrud.php';
require_once __DIR__.'/../admin/ChartData.php';
require_once __DIR__.'/../admin/ToolCrud.php';
require_once __DIR__.'/../admin/MenuCrud.php';
require_once __DIR__.'/../admin/ToolExecute.php';
require_once __DIR__.'/../admin/Upload.php';
require_once __DIR__.'/../admin/UserCrud.php';
require_once __DIR__.'/../admin/UserDataCrud.php';
require_once __DIR__.'/../admin/GroupCrud.php';
require_once __DIR__.'/../admin/UserGroupCrud.php';
require_once 'Misc.php';
require_once __DIR__.'/../admin/Settings.php';
require_once 'Log.php';

Class Crud {

        private $globalconf;

        public function CrudOperation($action, $table, $params, $con){


                $c = new Connection();
                $ds = new Dataset();
                $to = new Tools();
                $te = new ToolExecute();
                $vo = new ViewObjects();
                $v = new Views();
                $m = new Menus();
                $cd = new ChartData();
                $u = new User();
                $ud = new UserData();
                $ug = new UserGroup();
                $g = new Group();
                $s = new Settings();
                $misc = new Misc();
                $l = new Log();
                $up = new Upload();

                if ($table == 'connection') {
                        $l->varErrorLog('In CrudOperation, connection');
                        $c->ConnectionOperation($action, $params, $con);
                } else if ($table == 'dataset') {
                        $l->varErrorLog('In CrudOperation, dataset');
                        $ds->DatasetOperation($action, $params, $con);
                } else if ($table == 'toolexecute') {
                        $l->varErrorLog('In CrudOperation, toolexecute');
                        $te->ToolExecuteOperation($action, $params, $con);
                } else if ($table == 'chartdata') {
                        $l->varErrorLog('In CrudOperation, chartdata');
                        $chartdata = $cd->GetOperation($action, $params, $con);
			return $chartdata;
                } else if ($table == 'viewobjects') {
                        $l->varErrorLog('In CrudOperation, viewobjects');
                        $vo->ViewObjectOperation($action, $params, $con);
                } else if ($table == 'views') {
                        $l->varErrorLog('In CrudOperation, views');
                        $v->ViewOperation($action, $params, $con);
                } else if ($table == 'userdata') {
                        $l->varErrorLog('In CrudOperation, userdata');
                        $ud->UserDataOperation($action, $params, $con);
                } else if ($table == 'tools') {
                        $l->varErrorLog('In CrudOperation, tools');
                        $to->ToolsOperation($action, $params, $con);
                } else if ($table == 'menus') {
                        $l->varErrorLog('In CrudOperation, tools');
                        $m->MenusOperation($action, $params, $con);
                } else if ($table == 'actionpackage' || $table == 'textfile' || $table=='licensefile') {
                        $l->varErrorLog('In CrudOperation, upload');
                        $up->UploadOperation($action, $params, $con);
                } else if ($table == 'settings') {
                        $l->varErrorLog('In CrudOperation, settings');
                        $s->SettingsOperation($action, $params, $con);
                } else if ($table == 'users') {
                        //$l->varErrorLog('In CrudOperation, users');
                        $u->UserOperation($action, $params, $con);
                } else if ($table == 'groups') {
                        $l->varErrorLog('In CrudOperation, groups');
                        $g->GroupOperation($action, $params, $con);
                } else if ($table == 'user_groups') {
                        $l->varErrorLog('In CrudOperation, user_groups');
                        $ug->UserGroupOperation($action, $params, $con);
                } else if ($table == 'task_runbooks') {
                        $l->varErrorLog('In CrudOperation, task_runbooks');
                        $rt->RunbookTaskOperation($action, $params, $con);
                } else if ($table == 'group_runbooks') {
                        $l->varErrorLog('In CrudOperation, group_runbooks');
                        $rg->RunbookGroupOperation($action, $params, $con);
                } else if ($table == 'misc') {
                        $l->varErrorLog('In CrudOperation, misc');
                        $misc->MiscOperation($action, $params, $con);
                }

        }
}

