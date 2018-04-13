define(function (require) {
	var LISTCONFIGS = require("../admin/listconfigs");
	var MESSAGES = require("../../client/messages/messages");
	var UTILS = require('../../client/utils/misc');

   var getToolMenus = function(targetform, targetfield) {
        UTILS.ajaxPost('get', 'menus', {"menutype":"Tools"}, function(response) {
                        var menunames = [];
                       response.records.forEach(function(menu){
                                   menunames.push(menu.menuname);
                                   if (menunames.length == response.total) {
                                       targetfield.options.items = menunames;
                                       targetform.refresh();
                                   }
                        })
        })
   }
   var getViewMenus = function(targetform, targetfield) {
        UTILS.ajaxPost('get', 'menus', {"menutype":"Views"}, function(response) {
                        var menunames = [];
                       response.records.forEach(function(menu){
                                   menunames.push(menu.menuname);
                                   if (menunames.length == response.total) {
                                       targetfield.options.items = menunames;
                                       targetform.refresh();
                                   }
                        })
        })
   }
	var getDS = function (targetform, targetfield) {
        UTILS.ajaxPost('get', 'dataset', '', function(response) {
                        var setnames = [];
                       response.records.forEach(function(ds){
                                   setnames.push(ds.setname);
                                   if (setnames.length == response.total) {
                                       targetfield.options.items = setnames;
                                       targetform.refresh();
                                   }
                        })
               })
	}

    return {
      pyramid: {
		name: 'viewobjectform_pyramid',
		header: 'View Object Config: Pyramid/Cone/Funnel Chart',
		url: 'app/server/main.php',
		method: 'POST',
		show: {
		  header         : true,
		  toolbar        : true,
		  footer        : true
		},
		tabs: [
			{ id: 'tab1', caption: 'Data' },
			{ id: 'tab2', caption: 'Effects/Labels'},
			{ id: 'tab3', caption: 'Titles' }
		],
		toolbar: {
		  items: [
		    { id: 'new', type: 'button', caption: 'New', img: 'newicon' },
		    { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
		    { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
		  ],
		  onClick: function (event) {
		    if (event.target == 'clear') w2ui.viewobjectform_pyramid.clear();
		    if (event.target == 'new') {
			  LISTCONFIGS.launch();
		    }
		    if (event.target == 'save') {
		      var record = w2ui.viewobjectform_pyramid.record
		      // The corresponding part of the record for dropdowns should be objects, but check just in case.
		      record.objtype = 'chart';
		      record.charttype = 'pyramid';
		      if (record.setname instanceof Object) {
			  record.setname = record.setname.text
		      }
		      if (record.charttitlefont instanceof Object) {
			  record.charttitlefont = record.charttitlefont.id
		      }
		      if (record.chartpyramideffect instanceof Object) {
			  record.chartpyramideffect = record.chartpyramideffect.id
		      }
		      if (record.chartpyramidlabels instanceof Object) {
			  record.chartpyramidlabels = record.chartpyramidlabels.id
		      }
		      if (record.chartpyramidfont instanceof Object) {
			  record.chartpyramidfont = record.chartpyramidfont.id
		      }
		      if (record.chartpyramidlayergap instanceof Object) {
			  record.chartpyramidlayergap = record.chartpyramidlayergap.id
		      }
		      if (record.chartsubtitlefont instanceof Object) {
			  record.chartsubtitlefont = record.chartsubtitlefont.id
		      }
		      if (record.chartsubtitleposition instanceof Object) {
			  record.chartsubtitleposition = record.chartsubtitleposition.id
		      }
		      if (record.toolbarmenu instanceof Object) {
			  record.toolbarmenu = record.toolbarmenu.text
		      }
		      if (record.viewmenu instanceof Object) {
			  record.viewmenu = record.viewmenu.text
		      }
		      if (record.contextmenu instanceof Object) {
			  record.contextmenu = record.contextmenu.text
		      }
			  if (record.objname == null) {
				  MESSAGES.needviewobjectname();
			  } else {
			      UTILS.ajaxPost('save', 'viewobjects', record, function(response) {
				    if (response.records.length > 0) {
				    MESSAGES.viewobjectsaved();
				    w2ui.viewobjectgrid.records = response.records;
				    w2ui.viewobjectgrid.refresh();
				    }
			      })
			  }
		    }
		  }
		},
		onRender: function(event){
			  event.onComplete = function(){
				  getDS(w2ui.viewobjectform_pyramid, w2ui.viewobjectform_pyramid.fields[1]);
				  getToolMenus(w2ui.viewobjectform_pyramid, w2ui.viewobjectform_pyramid.fields[2]);
				  getViewMenus(w2ui.viewobjectform_pyramid, w2ui.viewobjectform_pyramid.fields[3]);
			  }
		},
		fields: [
                  { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
                  { name: 'setname',  type: 'list', required: true, options: { items: [] }, html: { caption: 'Obj. Type', attr: 'size="40" maxlength="40"' }},
                  { name: 'toolbarmenu',  type: 'list', required: true, options: { items: [] }, html: { caption: 'Tool Bar', attr: 'size="40" maxlength="40"' }},
                  { name: 'viewmenu',  type: 'list', required: true, options: { items: [] }, html: { caption: 'View Menu', attr: 'size="40" maxlength="40"' }},
                  { name: 'chartpyramidlabels',  type: 'list', required: true, options: { items: ['OnTop','Side'] }, html: { caption: 'Pyramid Labels', attr: 'size="40" maxlength="40"' }},
                  { name: 'chartpyramideffect',  type: 'list', required: true, options: { items: ['Pyramid','3D Pyramid','Cone','Funnel'] }, html: { caption: 'Pyramid Effect', attr: 'size="40" maxlength="40"' }},
                  { name: 'objname', type: 'text', required: true, html: { caption: 'Object Name', attr: 'size="80" maxlength="80"' } },
                  { name: 'charttitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'refreshrate', type: 'text', required: false, html: { caption: 'Refresh Rate', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartwidth', type: 'int', required: false, html: { caption: 'Chart Width', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartheight', type: 'int', required: false, html: { caption: 'Chart Width', attr: 'size="80" maxlength="80"' } },
                  { name: 'charttitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
                  { name: 'reststartproperty', type: 'text', required: false, html: { caption: 'JSON Start Property', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartpyramidlayergap', type: 'list', required: false, options: { items: [{id:"0.00",text:"0"},{id:"0.01",text:"1"}, {id:"0.02",text:"2"},{id:"0.03",text:"3"},{id:"0.04",text:"4"},{id:"0.05",text:"5"}] },html: { caption: 'Chart Layer Gap', attr: 'size="80" maxlength="80"' } },
                  { name: 'charttitlefont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartpyramidfont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
                  { name: 'charttitlefontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'charttitlebgcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'charttitleedgecolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartsubtitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartsubtitlefont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartsubtitlefontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartsubtitlebgcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartsubtitleedgecolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartsubtitleposition', type: 'list', required: false, options: { items:[{id:"1",text:"Bottom Left"}, {id:"2",text:"Bottom Center"}, {id:"3",text:"Bottom Right"}, {id:"4",text:"Left"}, {id:"5",text:"Center"}, {id:"6",text:"Right"}, {id:"7",text:"Top Left"}, {id:"8",text:"Top Center"}, {id:"9",text:"Top Right"}] }, html: { caption: 'Chart Subtitle Position', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartpyramidfontcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartpyramidcolor_multi', type: 'text', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartdscolx', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartdscoly', type: 'text', required: true, html: { caption: 'Y Axis Data', attr: 'size="80" maxlength="80"' } }
		],
		records: [
		]
	}

    };
});

