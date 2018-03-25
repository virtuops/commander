define(function (require) {
	var LISTCONFIGS = require("../admin/listconfigs");
	var MESSAGES = require("../../client/messages/messages");
	var UTILS = require('../../client/utils/misc');

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
      pie: {
		name: 'viewobjectform_pie',
		header: 'View Object Config: Pie Chart',
		url: 'app/server/main.php',
		method: 'POST',
		show: {
		  header         : true,
		  toolbar        : true,
		  footer        : true
		},
		tabs: [
			{ id: 'tab1', caption: 'Data' },
			{ id: 'tab2', caption: 'Size/Pos'},
			{ id: 'tab3', caption: 'Titles' },
			{ id: 'tab4', caption: 'Chart Body' }
		],
		toolbar: {
		  items: [
		    { id: 'new', type: 'button', caption: 'New', img: 'newicon' },
		    { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
		    { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
		  ],
		  onClick: function (event) {
		    if (event.target == 'clear') w2ui.viewobjectform_pie.clear();
		    if (event.target == 'new') {
			  LISTCONFIGS.launch();
		    }
		    if (event.target == 'save') {
		      var record = w2ui.viewobjectform_pie.record
		      // The corresponding part of the record for dropdowns should be objects, but check just in case.
		      record.objtype = 'chart';
		      record.charttype = 'pie';
		      if (record.setname instanceof Object) {
			  record.setname = record.setname.text
		      }
		      if (record.charttitlefont instanceof Object) {
			  record.charttitlefont = record.charttitlefont.id
		      }
		      if (record.chartpieeffect instanceof Object) {
			  record.chartpieeffect = record.chartpieeffect.id
		      }
		      if (record.chartpielabels instanceof Object) {
			  record.chartpielabels = record.chartpielabels.id
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
				  getDS(w2ui.viewobjectform_pie, w2ui.viewobjectform_pie.fields[1]);
			  }
		},
		fields: [
		  { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
		  { name: 'setname',  type: 'list', required: true, options: { items: [] }, html: { caption: 'Obj. Type', attr: 'size="40" maxlength="40"' }},
		  { name: 'chartpieeffect',  type: 'list', required: true, options: { items: ['3D','Gradient', '3D Gradient','Donut','Donut Gradient','3D Donut','3D Donut Gradient'] }, html: { caption: 'Bar Effect', attr: 'size="40" maxlength="40"' }},
		  { name: 'chartpielabels',  type: 'list', required: true, options: { items: ['Normal','OnTop','WithColors'] }, html: { caption: 'Bar Effect', attr: 'size="40" maxlength="40"' }},
		  { name: 'chartpiebreakoutslice', type: 'int', required: true, html: { caption: 'Object Name', attr: 'size="80" maxlength="80"' } },
		  { name: 'objname', type: 'text', required: true, html: { caption: 'Object Name', attr: 'size="80" maxlength="80"' } },
		  { name: 'refreshrate', type: 'text', required: false, html: { caption: 'Refresh Rate', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartwidth', type: 'text', required: false, html: { caption: 'Chart Width', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartheight', type: 'text', required: false, html: { caption: 'Chart Height', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'reststartproperty', type: 'text', required: false, html: { caption: 'JSON Start Prop', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitlefont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitlefontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitlebgcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitlefont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitlefontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitlebgcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitleedgecolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitleedgecolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitleposition', type: 'list', required: false, options: { items:[{id:"1",text:"Bottom Left"}, {id:"2",text:"Bottom Center"}, {id:"3",text:"Bottom Right"}, {id:"4",text:"Left"}, {id:"5",text:"Center"}, {id:"6",text:"Right"}, {id:"7",text:"Top Left"}, {id:"8",text:"Top Center"}, {id:"9",text:"Top Right"}] }, html: { caption: 'Chart Subtitle Position', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartpiecolor_multi', type: 'text', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartdscolx', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartdscoly', type: 'text', required: true, html: { caption: 'Y Axis Data', attr: 'size="80" maxlength="80"' } }
		],
		records: [
		]
	}

    };
});

