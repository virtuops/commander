<?php
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

$nhuser = $params['nhuser'] = $_GET['username'];
$objname = $params['objname'] = $_GET['objname'];
$params['panel'] = $_GET['panel'];
$params['nocviewname'] = $_GET['nocviewname'];

$gridparams = $c->CrudOperation('getparams','griddata',$params,'null');

$gridparams['nhuser'] = $_GET['username'];
$gridparams['dbhost'] = $settings['dbhost'];
$gridparams['dbuser'] = $settings['dbuser'];
$gridparams['dbpass'] = $settings['dbpass'];
$gridparams['dbname'] = $settings['dbname'];
$gridparams['dbport'] = $settings['dbport'];

$gridname = $params['nocviewname'].'_'.$params['panel'].'_grid';
$gridcolumns = $gridparams['gridcolumns'];
$contextmenuname = $gridparams['contextmenu'];
$toolbarmenuname = $gridparams['toolbarmenu'];
$refreshrate = $gridparams['refreshrate'];
$connectiontype = $gridparams['connectiontype'];
$url = $gridparams['url'];
$fileloc = $gridparams['fileloc'];
$query = $gridparams['query'];
$colformat = isset($gridparams['colformat']) && strlen($gridparams['colformat']) > 0 ? $gridparams['colformat'] : '[]';

$records = getGridData($c, $gridparams);


$contextmenu = json_encode($c->CrudOperation('getcontextmenu','griddata',$gridparams,'null'));
$toolbarmenu = $c->CrudOperation('gettoolbarmenu','griddata',$gridparams,'null');


$break = array("type"=>"break");
$export = array("type"=>"button", "id"=>"export", "caption"=>"Export", "img"=>"icon-folder");
array_push($toolbarmenu,$break);
array_push($toolbarmenu,$export);
array_push($toolbarmenu,$break);

$toolbarmenu = json_encode($toolbarmenu);

$header = $_GET['objname'];

function getGridData($c, $params){
$griddata = $c->CrudOperation('getgriddata','griddata',$params,'null');
return $griddata;
}



?>

<!DOCTYPE html>
<html>
<head>
    <title>NOC Hero™ Commander Grid</title>
    <link rel="stylesheet" type="text/css" href="../../../libs/w2ui/w2ui-1.5.rc1.min.css" />
    <link rel="stylesheet" type="text/css" href="../../../libs/css/mkadvantage.css" />
    <script type = "text/javascript" src="../../../libs/jquery/jquery-3.1.1.min.js"></script>
    <script type = "text/javascript" src="../../../libs/w2ui/w2ui-1.5.rc1.min.js"></script>
</head>
<body>

<div id="grid" style="width: 100%; height: 550px;"></div>

<script type="text/javascript">

var gridname = '<?php echo $gridname?>';
var ajaxPost =  function(cmd, table, params, callback) {
     var url = '../../../app/server/main.php';
     postData = { table: table, params: params, cmd: cmd };

     $.ajax({ type: 'POST', url: url, data: postData })
       .done(function(data) {
         callback(data)
       })
       .fail(function(err) {
       })
}

var refreshMyGrid = function(refreshrate) {
	params = <?php echo json_encode($gridparams) ?>;
        ajaxPost('refreshgriddata','griddata',params,function(response){
		var rowformat = <?php echo $colformat ?>;
                response = formatRows(response, rowformat);
                w2ui[gridname].records = response;
                w2ui[gridname].refresh();
        });
	setTimeout(function(){refreshMyGrid(refreshrate);}, refreshrate);
}

var formatRows = function(currentdata, rowformat) {


	var x = 0;
	currentdata.forEach(function(datarow){
		rowformat.forEach(function(rfrow){
			for (var prop in rfrow) {
				if (datarow.hasOwnProperty(prop)) {
					if (rfrow[prop] === datarow[prop]) {
					currentdata[x].w2ui = {};
					currentdata[x].w2ui.style = rfrow.style;
					} 
				}

			}

		});
	x++;
	});
	return currentdata; 
}

var toolResponse = function(response,toolname){
    w2popup.open({
        title     : toolname+' Response',
        body      : '<div class="w2ui-centered">'+response.message+'</div>',
        buttons   : '<button class="w2ui-btn" onclick="w2popup.close();">Close</button> ',
        width     : 500,
        height    : 300,
        overflow  : 'hidden',
        color     : '#333',
        speed     : '0.3',
        opacity   : '0.8',
        modal     : true,
        showClose : true,
        showMax   : true
    });
}


var gridtemplate = {
    name: gridname,
    header: '<?php echo $header; ?>',
    multiSearch: true,
    toolbar: {
        items: <?php echo $toolbarmenu; ?>,
        onClick: function (target, data) {
                    if (target == 'export') {
                            var exportURL = 'downloadGridData.php';

                            var form = document.createElement('form');
                            form.style.display = "none";
                            form.method = 'POST';
                            form.name = 'excelExport';
                            form.action = exportURL;
			    var hiddenField1 = document.createElement('input');
			    hiddenField1.setAttribute("type", "hidden");
			    hiddenField1.setAttribute("name", "objname");
			    hiddenField1.setAttribute("value", '<?php echo $objname?>');
			    var hiddenField2 = document.createElement('input');
			    hiddenField2.setAttribute("type", "hidden");
			    hiddenField2.setAttribute("name", "connectiontype");
			    hiddenField2.setAttribute("value", '<?php echo $connectiontype?>');
			    var hiddenField3 = document.createElement('input');
			    hiddenField3.setAttribute("type", "hidden");
			    hiddenField3.setAttribute("name", "url");
			    hiddenField3.setAttribute("value", '<?php echo $url?>');
			    var hiddenField4 = document.createElement('input');
			    hiddenField4.setAttribute("type", "hidden");
			    hiddenField4.setAttribute("name", "fileloc");
			    hiddenField4.setAttribute("value", '<?php echo $fileloc?>');
			    var hiddenField5 = document.createElement('input');
			    hiddenField5.setAttribute("type", "hidden");
			    hiddenField5.setAttribute("name", "query");
			    hiddenField5.setAttribute("value", '<?php echo $query?>');
			    form.appendChild(hiddenField1);
			    form.appendChild(hiddenField2);
			    form.appendChild(hiddenField3);
			    form.appendChild(hiddenField4);
			    form.appendChild(hiddenField5);
                            document.body.appendChild(form);

                            form.submit();
                    }
		    if (target == 'w2ui-reload') {
			params = <?php echo json_encode($gridparams) ?>;
			ajaxPost('refreshgriddata','griddata',params,function(response){
				var rowformat = <?php echo $colformat ?>;
				response = formatRows(response, rowformat);
				w2ui[gridname].records = response;
				w2ui[gridname].refresh();
			});
		    }

		if (data.item.tooltype == 'Program') {
                	toolprogram = data.item.program;
                	tooltype = data.item.tooltype;
                	toolname = data.item.text;
                	ajaxPost('firetool','toolexecute',params,function(response){
                        toolResponse(response,toolname);
               		});
               	} else if (data.item.tooltype == 'URL') {
               		window.open(data.item.launchurl);
               	}
            }
    },
    show: {
        header         : true,
        toolbar     : true,
        footer        : true
    },
    menu: <?php echo $contextmenu; ?>,
    onRender: function(event){
	    var gridname = '<?php echo $gridname ?>';
            event.onComplete = function(){
		var rowformat = <?php echo $colformat ?>;
		var rawrecords = <?php echo $records ?>;
		var records = formatRows(rawrecords, rowformat);
		this.records = records;
		this.refresh();	
		var refreshrate = '<?php echo $refreshrate?>';
		refreshrate = refreshrate * 1000
		setTimeout(function(){refreshMyGrid(refreshrate);}, refreshrate);
            }
    },
    onMenuClick: function(event){
            selrecords = this.get(this.getSelection());
            toolprogram = event.menuItem.program;
            everyrow = event.menuItem.everyrow;
            toolfields = event.menuItem.toolfields;
            launchurl = event.menuItem.launchurl;
            tooltype = event.menuItem.tooltype;
            toolname = event.menuItem.text;

            params = {
                    "toolprogram":toolprogram,
                    "selrecords":selrecords,
                    "everyrow":everyrow,
                    "toolfields":toolfields
                    }

            if (tooltype == 'Program') {
            ajaxPost('firetool','toolexecute',params,function(response){
                    toolResponse(response,toolname);
            });
            } else if (tooltype == 'URL') {
                window.open(launchurl);
        }

    },
    columns: <?php echo $gridcolumns ?>,
    records: <?php echo $records ?> 
};

$('#grid').w2grid(gridtemplate);


</script>

</body>
</html>

