<?php

require_once __DIR__.'/../admin/ChartData.php';
require_once __DIR__.'/../admin/GridData.php';
require_once 'Misc.php';
require_once __DIR__.'/../admin/Settings.php';
require_once 'Log.php';

Class DataCrud {


        public function CrudOperation($action, $table, $params, $con){

                $cd = new ChartData();
                $gd = new GridData();
                $s = new Settings();
                $misc = new Misc();
                $l = new Log();

                if ($table == 'chartdata') {
                        $l->varErrorLog('In CrudOperation, chartdata');
                        $chartdata = $cd->GetOperation($action, $params, $con);
			return $chartdata;
                }
                if ($table == 'griddata') {
                        $l->varErrorLog('In CrudOperation, griddata');
                        $griddata = $gd->GetOperation($action, $params, $con);
			return $griddata;
                }
        }
}
