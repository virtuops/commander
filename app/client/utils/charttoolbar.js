define(function (require) {
    var UTILS = require('../utils/misc');
    return {
	ctb:  function (tbid, panel, viewobjects, charttoolbar) {

		var allowedTools = [{ id: 'id1', text: 'Select Tool', img: 'toolsicon' }];
		var allowedViews = [{ id: 'id1', text: 'Select View', img: 'viewsicon' }];
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
		     //initialization of popup outout in memory
		     params = {};
		     params.username = viewobjects.username;
		     params.toolbarmenu = charttoolbar;
		     UTILS.ajaxPost('gettoolbarmenu','chartdata',params,function(response){
			console.log('toolbar response');
			console.log(response);
			if (response.menutype == 'Tools') {
			response.menuitems.forEach(function(tool){
			allowedTools.push(tool);	
			});
			} else if (response.menutype == 'Views') {
			response.menuitems.forEach(function(view){
			allowedViews.push(view);	
			});
			}
			addItems(tbid, panel, allowedTools, allowedViews);
			setClicks(tbid);
		     });
		     if (typeof w2ui.outputgrid !== 'undefined') {
			w2ui.outputgrid.destroy();
			w2ui.outputlayout.destroy();
		     	$().w2layout(config.outputlayout);
		     	$().w2grid(config.outputgrid);
			} else {
		     	$().w2layout(config.outputlayout);
		     	$().w2grid(config.outputgrid);
			}
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
	
		var addItems = function(tbid, panel, allowedTools, allowedViews){  
		    w2ui[tbid].add([
                    { type: 'menu', id: panel+'_item1', img: 'toolsicon',
                        text: function (item) {
                            var text = item.selected;
                            var el   = this.get(panel+'_item1:' + item.selected);
                            return el.text;
                        },
                        selected: 'id1',
                        items: allowedTools
                    },
                    { type: 'break' },
                    { type: 'menu', id: panel+'_item2', img: 'viewsicon',
                        text: function (item) {
                            var text = item.selected;
                            var el   = this.get(panel+'_item2:' + item.selected);
                            return el.text;
                        },
                        selected: 'id1',
                        items: allowedViews
                    },
                ]);
		}

		var setClicks = function(tbid){
			w2ui[tbid].on('click',function(target,data){
			if (typeof data.subItem !== 'undefined') {
				if (data.subItem.tooltype == 'Program') {
				params = {};
				params.toolprogram = data.subItem.program;
				params.tooltype = data.subItem.tooltype;
				params.outputcols = JSON.stringify(data.subItem.outputcols);
				params.toolname = data.subItem.text;
				params.everyrow = 'false';
				params.multirow = 'false';
				params.toolfields = 'empty';
				UTILS.ajaxPost('firetool','toolexecute',params,function(response){
				toolResponse(response,params.toolname);
				});
				} else if (data.subItem.tooltype == 'URL') {
				window.open(data.subItem.launchurl);
				} else if (data.subItem.tooltype == 'View') {
				//need popup here for the new view
				console.log('You clicked on a view');
				}
			}
		});
		}

	}
     }
});

