define(function (require) {
    var LOGIN = require('../../client/admin/login');
    var MESSAGES = require('../../client/messages/messages');
    var LAYOUTS = require('../../client/mainview/layout');
    var BUILDMENU = require('../sidemenu/buildmenu');
    var TB = require('../../client/utils/toolbar');
    var UTILS = require('../../client/utils/misc');
    var userdata = {};
    var username = '';


    var updateSideMenu = function(data){

	var sidebarobj = w2ui.sidebar;
	
	for (var prop in data.views) {	
		id = data.views[prop].nocviewname;	
		title = data.views[prop].title;
		var nodeexist = w2ui.sidebar.get('myviewsmenu', id);
		if (nodeexist == null) {
		menutoadd = {id: id, text: title, img: 'viewsicon'};
		sidebarobj.add('myviewsmenu', menutoadd);
		sidebarobj.refresh();
		}
	}

    }

    var redrawChart = function(chartid, refreshrate) {
	if (! document.getElementById(chartid)) {
		//wait
	} else {
        	JsChartViewer.get(chartid).streamUpdate();
	}
        setTimeout(function(){redrawChart(chartid,refreshrate);}, refreshrate);
    }


    var setContent = function(layout, view){
                w2ui.layoutmain.content('main',layout);
                viewobj = view.viewobjects;
		viewname = view.nocviewname;
		Object.keys(viewobj).forEach(function(prop) {
			var panel = prop.substring(0, prop.length - 5);
			if (viewobj[prop].objtype == 'html') {
				console.log('HTML');
				content =  viewobj[prop].objmarkup;
				layout.content(panel,content);
				var objname = viewobj[prop].objname;
				var toolbar = viewobj[prop].toolbarmenu;
				var viewmenu = viewobj[prop].viewmenu;
				var chartid = objname.replace(/\s/g,'');
				var chartid = chartid.replace(/\s/g,'');
				var tbid = layout.name+'_'+panel+'_toolbar';
				viewobj.username = username;
				console.log('menunames are '+toolbar+' and '+viewmenu);
				$(function(){TB.ctb(tbid,panel,viewobj,toolbar,viewmenu)});
			}
			if (viewobj[prop].objtype == 'chart') {
				var charttype = viewobj[prop].charttype;
				var refreshrate = viewobj[prop].refreshrate * 1000;
				var objname = viewobj[prop].objname;
				var toolbar = viewobj[prop].toolbarmenu;
				var viewmenu = viewobj[prop].viewmenu;
				var chartid = objname.replace(/\s/g,'');
				var chartid = chartid.replace(/\s/g,'');
				var tbid = layout.name+'_'+panel+'_toolbar';
					
				content = //'<div id="'+tbid+'"></div>'+
					'<div style="height: 100%; width: 100%;">'+
               				'<img id="'+chartid+'" src="html/nhcpages/php/'+charttype+'.php?charttype='+charttype+'&objname='+objname+'">'+
		            		'</div>';

				
				layout.content(panel,content);
				viewobj.username = username;
				$(function(){TB.ctb(tbid,panel,viewobj,toolbar,viewmenu)});

				setTimeout(redrawChart(chartid,refreshrate),refreshrate);


			}
			if (viewobj[prop].objtype == 'grid') {

                                var objname = viewobj[prop].objname;
                                content = '<div class="hide-scroll-bars"><iframe class="chart-frame-content" src="html/nhcpages/php/grid.php?nocviewname='+viewname+'&panel='+panel+'&username='+username+'&objname='+objname+'" style="height: 100%; width: 100%;"></iframe></div>';
                                layout.content(panel,content);

			}
			if (viewobj[prop].objtype == 'iframe') {
				content = '<div class="iframe-wrapper"><iframe src="'+viewobj[prop].objurl+'" style="position: absolute; height: 100%; width: 100%; border: none;"></iframe></div>'
				layout.content(panel,content);
				var objname = viewobj[prop].objname;
				var toolbar = viewobj[prop].toolbarmenu;
				var viewmenu = viewobj[prop].viewmenu;
				var chartid = objname.replace(/\s/g,'');
				var chartid = chartid.replace(/\s/g,'');
				var tbid = layout.name+'_'+panel+'_toolbar';
				viewobj.username = username;
				$(function(){TB.ctb(tbid,panel,viewobj,toolbar,viewmenu)});
			}
		});
    }

    var configLayout = function(event){
	viewname = event.target;
	for (var prop in userdata.views) {
		var view = userdata.views[prop];
		if (view.nocviewname == viewname) {
			if (view.canvasname == 'main') {
                           if (w2ui.main) { w2ui.main.destroy() }
			    $().w2layout(LAYOUTS.main);
                            setContent(w2ui.main, view);
                        }
			if (view.canvasname == 'topmain') {
			   if (w2ui.topmain) { w2ui.topmain.destroy() }
			    $().w2layout(LAYOUTS.topmain(view.topsize, view.mainsize));
			    setContent(w2ui.topmain, view);
			}
			if (view.canvasname == 'topmainbottom') {
			   if (w2ui.topmainbottom) { w2ui.topmainbottom.destroy() }
			    $().w2layout(LAYOUTS.topmainbottom(view.topsize, view.mainsize, view.bottomsize));
			    setContent(w2ui.topmainbottom, view);
			}
			if (view.canvasname == 'leftmain') {
			   if (w2ui.leftmain) { w2ui.leftmain.destroy() }
			    $().w2layout(LAYOUTS.leftmain(view.leftsize, view.mainsize));
			    setContent(w2ui.leftmain, view);
			}
			if (view.canvasname == 'rightmain') {
			   if (w2ui.rightmain) { w2ui.rightmain.destroy() }
			    $().w2layout(LAYOUTS.rightmain(view.rightsize, view.mainsize));
			    setContent(w2ui.rightmain, view);
			}
			if (view.canvasname == 'leftmainright') {
			   if (w2ui.leftmainright) { w2ui.leftmainright.destroy() }
			    $().w2layout(LAYOUTS.leftmainright(view.leftsize, view.mainsize, view.rightsize));
			    setContent(w2ui.leftmainright, view);
			}
			if (view.canvasname == 'topmainright') {
			   if (w2ui.topmainright) { w2ui.topmainright.destroy() }
			    $().w2layout(LAYOUTS.topmainright(view.topsize, view.mainsize, view.rightsize));
			    setContent(w2ui.topmainright, view);
			}
			if (view.canvasname == 'topmainleft') {
			   if (w2ui.topmainleft) { w2ui.topmainleft.destroy() }
			    $().w2layout(LAYOUTS.topmainleft(view.topsize, view.mainsize, view.leftsize));
			    setContent(w2ui.topmainleft, view);
			}
			if (view.canvasname == 'topleftmainbottom') {
			   if (w2ui.topleftmainbottom) { w2ui.topleftmainbottom.destroy() }
			    $().w2layout(LAYOUTS.topleftmainbottom(view.topsize, view.leftsize, view.mainsize, view.bottomsize));
			    setContent(w2ui.topleftmainbottom, view);
			}
			if (view.canvasname == 'toprightmainpreview') {
			   if (w2ui.toprightmainpreview) { w2ui.toprightmainpreview.destroy() }
			    $().w2layout(LAYOUTS.toprightmainpreview(view.topsize, view.rightsize, view.mainsize, view.previewsize));
			    setContent(w2ui.toprightmainpreview, view);
			}
			if (view.canvasname == 'topleftmainpreview') {
			   if (w2ui.topleftmainpreview) { w2ui.topleftmainpreview.destroy() }
			    $().w2layout(LAYOUTS.topleftmainpreview(view.topsize, view.leftsize, view.mainsize, view.previewsize));
			    setContent(w2ui.topleftmainpreview, view);
			}
			if (view.canvasname == 'toprightmainpreviewbottom') {
			   if (w2ui.toprighttmainpreviewbottom) { w2ui.toprightmainpreviewbottom.destroy() }
			    $().w2layout(LAYOUTS.toprightmainpreviewbottom(view.topsize, view.rightsize, view.mainsize, view.previewsize, view.bottomsize));
			    setContent(w2ui.toprightmainpreviewbottom, view);
			}
			if (view.canvasname == 'topleftmainpreviewbottom') {
			   if (w2ui.toplefttmainpreviewbottom) { w2ui.topleftmainpreviewbottom.destroy() }
			    $().w2layout(LAYOUTS.topleftmainpreviewbottom(view.topsize, view.leftsize, view.mainsize, view.previewsize, view.bottomsize));
			    setContent(w2ui.topleftmainpreviewbottom, view);
			}
			if (view.canvasname == 'all') {
			   if (w2ui.all) { w2ui.all.destroy() }
			    $().w2layout(LAYOUTS.all(view.topsize, view.leftsize, view.rightsize, view.mainsize, view.previewsize, view.bottomsize));
			    setContent(w2ui.all, view);
			}
	

		}
	}
	
    }

    return {
        sidebar: {
                name       : 'sidebar',
                topHTML    : '<div id="nocherologo"><img id="nocheroicon" src="html/images/1.1.png"></img><div id="nocherotext">VirtuOps<sup><span style="font-size: 10px;">&reg;</span></sup><br>Commander</div></div>',
                onRender: function(event) {
			event.onComplete = function(){
		        var sessionID = UTILS.getsessionid('PHPSESSID');
			UTILS.getusername(sessionID, function(data){
				username = data.records[0].username;
				var userobj = {
				       username: username 
				}

				BUILDMENU.buildsidebar(userobj);
				UTILS.ajaxPost('getall','userdata',{"username":username,"objdata":"no"},function(opdata){
					userdata = opdata;
					updateSideMenu(opdata);
				})
			    })
			}
                },
                onClick: function (event) {
                    //var sidebar = this;
                    switch (event.target) {
                        case 'connections':
                            w2ui.layoutmain.content('main',w2ui.layout7030);
                            w2ui.layout7030.content('main',w2ui.connectionform);
                            w2ui.layout7030.content('right',w2ui.connectiongrid);
                            setTimeout(function(){w2ui.connectionform.refresh();}, 400);
                            break;
                        case 'datasets':
                            w2ui.layoutmain.content('main',w2ui.layout7030);
                            w2ui.layout7030.content('main',w2ui.datasetform);
                            w2ui.layout7030.content('right',w2ui.datasetgrid);
                            setTimeout(function(){w2ui.datasetform.refresh();}, 400);
                            break;
                        case 'helpabout':
                            MESSAGES.helpabout();
                            break;
                        case 'intro':
                            w2ui.layoutmain.content('main',w2ui.layoutsingle);
                            w2ui.layoutsingle.load('main','html/docs/intro.php');
                            break;
                        case 'documentation':
				/*
                            w2ui.layoutmain.content('main',w2ui.layoutsingle);
                            w2ui.layoutsingle.load('main','html/docs/docmain.html');
				*/
                            break;
                        case 'users':
                            w2ui.layoutmain.content('main',w2ui.layout2080);
                            w2ui.layout2080.content('top',w2ui.usertopgrid);
                            w2ui.layout2080.content('main',w2ui.userbottomform);
                            break;
                        case 'groups':
                            w2ui.layoutmain.content('main',w2ui.layout2080);
                            w2ui.layout2080.content('top',w2ui.grouptopgrid);
                            setTimeout(function() { w2ui.grouptopgrid.refresh() }, 50)
                            w2ui.layout2080.content('main',w2ui.groupbottomform);
                            setTimeout(function(){
                                //wait for groupbottomform to come up.
                                w2ui.gbfavailablemembers.render($('#gbfavailablemembers')[0]);
                                w2ui.gbfavailablemembers.refresh();
                                w2ui.gbfselectedmembers.render($('#gbfselectedmembers')[0])
                                w2ui.gbfselectedmembers.refresh();}, 1500
                                );
                            break;
                        case 'settings':
                            w2ui.layoutmain.content('main',w2ui.layoutsingle);
                            w2ui.layoutsingle.content('main',w2ui.settingsbottomform);
                            break;
                        case 'adminwizard':
				/*
                            w2ui.layoutmain.content('main',w2ui.layoutsingle);
                            w2ui.layoutsingle.content('main',w2ui.adminwizard);
				*/
                            break;
                        case 'tools':
                            w2ui.layoutmain.content('main',w2ui.layout7030);
                            w2ui.layout7030.content('main',w2ui.toolform);
                            w2ui.layout7030.content('right',w2ui.toolgrid);
                            setTimeout(function(){w2ui.toolform.refresh();}, 400);
                            break;
                        case 'menus':
                            w2ui.layoutmain.content('main',w2ui.layout7030);
                            w2ui.layout7030.content('main',w2ui.menuform);
                            w2ui.layout7030.content('right',w2ui.menugrid);
                            setTimeout(function(){w2ui.menuform.refresh();}, 400);
                            break;
                        case 'viewobjects':
                            w2ui.layoutmain.content('main',w2ui.layout7030);
                            w2ui.layout7030.content('main',w2ui.viewobjectform);
                            w2ui.layout7030.content('right',w2ui.viewobjectgrid);
                            setTimeout(function(){w2ui.viewobjectform.refresh();}, 400);
                            break;
                        case 'views':
                            w2ui.layoutmain.content('main',w2ui.layout7030);
                            w2ui.layout7030.content('main',w2ui.viewform);
                            w2ui.layout7030.content('right',w2ui.viewgrid);
                            setTimeout(function(){w2ui.viewform.refresh();}, 400);
                            break;
                        case 'logout':
                            window.location = 'logout.php'
                            break
			default:
				configLayout(event);
                        }
                },

        },
        init: function(){
        w2ui.layoutmain.content('left', $().w2sidebar(this.sidebar));
        }
    };
});

