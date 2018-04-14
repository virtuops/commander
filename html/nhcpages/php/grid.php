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
$panel = $_GET['panel'];
$params['nocviewname'] = $_GET['nocviewname'];
$viewname = $_GET['nocviewname'];

$l->varErrorLog("WHAT IS NOCVIEWNAME AGAIN???");
$l->varErrorLog($viewname);

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
$viewmenuname = $gridparams['viewmenu'];
$refreshrate = $gridparams['refreshrate'];
$connectiontype = $gridparams['connectiontype'];
$url = $gridparams['url'];
$fileloc = $gridparams['fileloc'];
$query = $gridparams['query'];
$colformat = isset($gridparams['colformat']) && strlen($gridparams['colformat']) > 0 ? $gridparams['colformat'] : '[]';

$records = getGridData($c, $gridparams);

$contextmenu = json_encode($c->CrudOperation('getcontextmenu','griddata',$gridparams,'null'));

$toolbarmenu = array();
$tbitems = $c->CrudOperation('gettoolbarmenu','griddata',$gridparams,'null');

$break = array("type"=>"break");
$export = array("type"=>"button", "id"=>"export", "caption"=>"Export", "img"=>"icon-folder");
array_push($toolbarmenu,$export);
array_push($toolbarmenu,$break);
array_push($toolbarmenu, $tbitems[0]);
array_push($toolbarmenu, $tbitems[1]);


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
    <title>VirtuOps&reg; Commander Grid</title>
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

var drillDownVO = function(voname) {
       ajaxPost('get', 'viewobjects', {"objname":voname}, function(response) {
               console.log(response);
               var viewobj = response.records[0];
               drillChart(viewobj);
       })
}

      var drillChart = function(viewobj){
              var objname = viewobj.objname;
	      var username = '<?php echo $nhuser ?>';
              var objurl = viewobj.objurl;
              var objmarkup = viewobj.objmarkup;
	      var viewname = '<?php echo $viewname ?>';
	      var panel = '<?php echo $panel ?>'
              var charttype = viewobj.charttype;
              var objtype = viewobj.objtype;
              var popid = objname+'_popup';

          w2popup.open({
              title     : objname,
              body      : '<div id="outputmain" style="position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;"></div>',
              buttons   : '<button class="w2ui-btn" onclick="w2popup.close();">Close</button> ',
              onOpen  : function (event) {
                  event.onComplete = function () {
                      var content;
                      if (objtype === 'chart') {
                      content = '<div style="height: 100%; width: 100%;">'+
                              '<img style="display: block; margin: auto;" id="'+popid+'" src="'+charttype+'.php?charttype='+charttype+'&objname='+objname+'">'+
                              '</div>';
                      } else if (objtype === 'grid') {
                      content = '<div class="hide-scroll-bars"><iframe class="chart-frame-content" src="grid.php?nocviewname='+viewname+'&panel='+panel+'&username='+username+'&objname='+objname+'" style="height: 100%; width: 100%;"></iframe></div>';
                      } else if (objtype === 'iframe') {
                      content = '<div class="iframe-wrapper"><iframe src="'+viewobj[prop].objurl+'" style="position: absolute; height: 100%; width: 100%; border: none;"></iframe></div>'
                      } else if (objtype === 'html') {
                              content = objmarkup;
                      }
                      $('#w2ui-popup #outputmain').w2render('outputlayout');
                      w2ui.outputlayout.content('main', content);
                  };
              },
              onToggle: function (event) {
                  event.onComplete = function () {
                      w2ui.outputlayout.resize();
                  }
              },
              width     : 1000,
              height    : 1000,
              overflow  : 'hidden',
              color     : '#333',
              speed     : '0.3',
              opacity   : '0.8',
              modal     : true,
              showClose : true,
              showMax   : true
          });
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

var config = {
    outputlayout: {
        name: 'outputlayout',
        padding: 4,
        panels: [
            { type: 'main', minSize: 300 }
        ]
    },
    outputgrid: { 
        name: 'outputgrid',
        columns: [
        ],
        records: [
        ]
    }
};

$(function () {
    // initialization of popup outout in memory
    $().w2layout(config.outputlayout);
    $().w2grid(config.outputgrid);
});



var toolResponse = function(response,toolname){
    w2popup.open({
        title     : toolname+' Response',
        body      : '<div id="outputmain" style="position: absolute; left: 5px; top: 5px; right: 5px; bottom: 5px;"></div>',
        buttons   : '<button class="w2ui-btn" onclick="w2popup.close();">Close</button> ',
        onOpen  : function (event) {
            event.onComplete = function () {
		w2ui.outputgrid.records = response.records;
		w2ui.outputgrid.columns = response.columns;
                $('#w2ui-popup #outputmain').w2render('outputlayout');
               	w2ui.outputlayout.content('main', w2ui.outputgrid);
		setTimeout(function(){w2ui.outputgrid.refresh()},500);
            };
        },
        onToggle: function (event) { 
            event.onComplete = function () {
                w2ui.outputlayout.resize();
            }
        },
        width     : 650,
        height    : 450,
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
			console.log(data);
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
			    hiddenField5.setAttribute("value", "<?php echo $query?>");
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

		if (typeof data.subItem !== 'undefined') {
			if (data.subItem.tooltype == 'Program') {
				toolprogram = data.subItem.program;
				tooltype = data.subItem.tooltype;
				outputcols = data.subItem.outputcols;
				toolname = data.subItem.text;
				ajaxPost('firetool','toolexecute',params,function(response){
				toolResponse(response,toolname);
				});
			} else if (data.subItem.tooltype == 'URL') {
				window.open(data.subItem.launchurl);
			} else if (data.subItem.tooltype == 'View') {
				voname = data.subItem.text;
				drillDownVO(voname);
			}
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
            multirow = event.menuItem.multirow;
            outputcols = event.menuItem.outputcols;
            launchurl = event.menuItem.launchurl;
            tooltype = event.menuItem.tooltype;
            toolname = event.menuItem.text;

            params = {
                    "toolprogram":toolprogram,
                    "selrecords":selrecords,
                    "everyrow":everyrow,
                    "multirow":multirow,
                    "outputcols":outputcols,
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

