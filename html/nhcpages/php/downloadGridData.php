<?php
// Original PHP code by Chirp Internet: www.chirp.com.au
require_once("../../../app/server/utils/DataCrud.php");
require_once("../../../app/server/utils/Log.php");

$c = new DataCrud();
$l = new Log();

$settings = parse_ini_file('../../../app/server/config.ini');
$params = array();
$dbhost = $params['dbhost'] = $settings['dbhost'];
$dbuser = $params['dbuser'] = $settings['dbuser'];
$dbpass = $params['dbpass'] = $settings['dbpass'];
$dbname = $params['dbname'] = $settings['dbname'];
$dbport = $params['dbport'] = $settings['dbport'];

$params['objname'] = $_POST['objname'];

$gridparams = $c->CrudOperation('getparams','griddata',$params,'null');


$gridparams['nhuser'] = $_POST['nhuser'];
$gridparams['dbhost'] = $settings['dbhost'];
$gridparams['dbuser'] = $settings['dbuser'];
$gridparams['dbpass'] = $settings['dbpass'];
$gridparams['dbname'] = $settings['dbname'];
$gridparams['dbport'] = $settings['dbport'];

$records = json_decode(getGridData($c, $gridparams ), true);

$l->varErrorLog("DOWNLOAD RECORDS:");
$l->varErrorLog($records);


function getGridData($c, $params){
$griddata = $c->CrudOperation('getgriddata','griddata',$params,'null');
return $griddata;
}


// file name for download
$filename = "grid_data_" . date('Ymd') . ".csv";

header("Content-Disposition: attachment; filename=\"$filename\"");
header("Content-Type: application/vnd.ms-excel");

$flag = false;
foreach($records as $row) {
  
  if(!$flag) {
    // display field/column names as first row
    //echo implode("\t", array_keys($row)) . "\n";
    echo implode(",", array_keys($row)) . "\n";
    $flag = true;
  }
  array_walk($row, 'cleanData');
  //echo implode("\t", array_values($row)) . "\n";
  echo implode(",", array_values($row)) . "\n";


}

function cleanData(&$str)
{
  $str = preg_replace("/\t/", "\\t", $str);
  $str = preg_replace("/\,/", " ", $str);
  $str = preg_replace("/\r?\n/", "\\n", $str);
  if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
}

/*
function getEvents($sql, $con) {

$stmt = $con->prepare($sql);
        $stmt->bind_result($node, $nodealias, $summary, $severity, $firstoccurrence, $lastoccurrence);
        $stmt->execute();

        $row = array();
        $result = array();


        while ($stmt->fetch()){

                $row['Node'] = $node;
                $row['NodeAlias'] = $nodealias;
                $row['Summary'] = $summary;
                $row['Severity'] = $severity;
                $row['FirstOccurrence'] = $firstoccurrence;
                $row['LastOccurrence'] = $lastoccurrence;

                array_push($result, $row);
        }
        return $result;

}
*/


exit;
?>
