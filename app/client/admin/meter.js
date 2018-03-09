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
      meter: {
		name: 'viewobjectform_meter',
		header: 'View Object Config: Meter Chart',
		url: 'app/server/main.php',
		method: 'POST',
		show: {
		  header         : true,
		  toolbar        : true,
		  footer        : true
		},
		tabs: [
			{ id: 'tab1', caption: 'Data' },
			{ id: 'tab3', caption: 'Effects/Labels' }
		],
		toolbar: {
		  items: [
		    { id: 'new', type: 'button', caption: 'New', icon: 'fa fa-file-text-o' },
		    { id: 'clear', type: 'button', caption: 'Reset', icon: 'fa fa-file-o' },
		    { id: 'save', type: 'button', caption: 'Save', icon: 'fa fa-floppy-o' }
		  ],
		  onClick: function (event) {
		    if (event.target == 'clear') w2ui.viewobjectform_meter.clear();
		    if (event.target == 'new') {
			  LISTCONFIGS.launch();
		    }
		    if (event.target == 'save') {
		      var record = w2ui.viewobjectform_meter.record
		      // The corresponding part of the record for dropdowns should be objects, but check just in case.
		      record.objtype = 'chart';
		      record.charttype = 'meter';
		      record.chartmetercolor = typeof record.chartmetercolor_multi !== "undefined" ? record.chartmetercolor_multi : record.chartmetercolor_single;
		      if (record.setname instanceof Object) {
			  record.setname = record.setname.text
		      }
		      if (record.chartmeterfont instanceof Object) {
			  record.chartmeterfont = record.chartmeterfont.id
		      }
		      if (record.chartmetereffect instanceof Object) {
			  record.chartmetereffect = record.chartmetereffect.id
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
				  getDS(w2ui.viewobjectform_meter, w2ui.viewobjectform_meter.fields[1]);
			  }
		},
		fields: [
		  { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
		  { name: 'setname',  type: 'list', required: true, options: { items: [] }, html: { caption: 'Obj. Type', attr: 'size="40" maxlength="40"' }},
		  { name: 'chartmetereffect',  type: 'list', required: true, options: { items: ['Horizontal','Vertical','Horiz. Bar','Vert. Bar'] }, html: { caption: 'Meter Effect', attr: 'size="40" maxlength="40"' }},
		  { name: 'objname', type: 'text', required: true, html: { caption: 'Object Name', attr: 'size="80" maxlength="80"' } },
		  { name: 'reststartproperty', type: 'text', required: false, html: { caption: 'Rest Start Prop', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmeterlabel', type: 'text', required: false, html: { caption: 'Chart Label', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmeterbeginscale', type: 'int', required: false, html: { caption: 'Chart Label', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmeterendscale', type: 'int', required: false, html: { caption: 'Chart Label', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartheight', type: 'int', required: false, html: { caption: 'Chart Radius', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartwidth', type: 'int', required: false, html: { caption: 'Chart Radius', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmetertickinterval', type: 'int', required: false, html: { caption: 'Chart Horiz', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmeterfont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmeterfontsize', type: 'int', required: false, html: { caption: 'Chart Title Font Size', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmeterlabelcolor', type: 'color', required: false, html: { caption: 'Chart Title Font Size', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmeterbgcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartmeterbordercolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartdscolx', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
		],
		records: [
		]
	}

    };
});

