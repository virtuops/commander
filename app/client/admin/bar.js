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
      bar: {
		name: 'viewobjectform_bar',
		header: 'View Object Config: Bar Chart',
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
			{ id: 'tab4', caption: 'Chart Body' },
			{ id: 'tab5', caption: 'Axes' },
			{ id: 'tab6', caption: 'Thresholds' },
		],
		toolbar: {
		  items: [
		    { id: 'new', type: 'button', caption: 'New', img: 'newicon' },
		    { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
		    { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
		  ],
		  onClick: function (event) {
		    if (event.target == 'clear') w2ui.viewobjectform_bar.clear();
		    if (event.target == 'new') {
			  LISTCONFIGS.launch();
		    }
		    if (event.target == 'save') {
		      var record = w2ui.viewobjectform_bar.record
		      // The corresponding part of the record for dropdowns should be objects, but check just in case.
		      record.objtype = 'chart';
		      record.charttype = 'bar';
		      record.chartbarcolor = typeof record.chartbarcolor_multi !== "undefined" ? record.chartbarcolor_multi : record.chartbarcolor_single;
		      if (record.setname instanceof Object) {
			  record.setname = record.setname.text
		      }
		      if (record.charttitlefont instanceof Object) {
			  record.charttitlefont = record.charttitlefont.id
		      }
		      if (record.chartytitlefont instanceof Object) {
			  record.chartytitlefont = record.chartytitlefont.id
		      }
		      if (record.chartxtitlefont instanceof Object) {
			  record.chartxtitlefont = record.chartxtitlefont.id
		      }
		      if (record.chartbarroundedcorners instanceof Object) {
			  record.chartbarroundedcorners = record.chartbarroundedcorners.id
		      }
		      if (record.chartbargrouptype instanceof Object) {
			  record.chartbargrouptype = record.chartbargrouptype.id
		      }
		      if (record.chartbarlabels instanceof Object) {
			  record.chartbarlabels = record.chartbarlabels.id
		      }
		      if (record.chartbareffect instanceof Object) {
			  record.chartbareffect = record.chartbareffect.id
		      }
		      if (record.chartsubtitlefont instanceof Object) {
			  record.chartsubtitlefont = record.chartsubtitlefont.id
		      }
		      if (record.chartaxisfont instanceof Object) {
			  record.chartaxisfont = record.chartaxisfont.id
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
				  getDS(w2ui.viewobjectform_bar, w2ui.viewobjectform_bar.fields[1]);
			  }
		},
		fields: [
		  { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
		  { name: 'setname',  type: 'list', required: true, options: { items: [] }, html: { caption: 'Obj. Type', attr: 'size="40" maxlength="40"' }},
		  { name: 'chartbarroundedcorners',  type: 'list', required: true, options: { items: ['true','false'] }, html: { caption: 'Rounded Corners', attr: 'size="40" maxlength="40"' }},
		  { name: 'chartbarlabels',  type: 'list', required: true, options: { items: ['true','false'] }, html: { caption: 'Bar Labels', attr: 'size="40" maxlength="40"' }},
		  { name: 'chartbareffect',  type: 'list', required: true, options: { items: ['Normal','Soft','Gradient','Glass','2DCylinder','3DBar','3DCylinder','3DBarSoft'] }, html: { caption: 'Bar Effect', attr: 'size="40" maxlength="40"' }},
		  { name: 'chartbargrouptype',  type: 'list', required: false, options: { items: ['MultiBar','Stacked','Percent'] }},
		  { name: 'objname', type: 'text', required: true, html: { caption: 'Object Name', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartwidth', type: 'text', required: false, html: { caption: 'Chart Width', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartheight', type: 'text', required: false, html: { caption: 'Chart Height', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartytitle', type: 'text', required: false, html: { caption: 'Chart Y Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartxtitle', type: 'text', required: false, html: { caption: 'Chart X Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitlefont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartaxisfont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartytitlefont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartxtitlefont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
		  { name: 'reststartproperty', type: 'text', required: false, html: { caption: 'JSON Start Prop', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartaxiscolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitlefontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartaxisfontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartaxisspacing', type: 'int', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartaxisangle', type: 'int', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartxtitlefontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartytitlefontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitlebgcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'charttitleedgecolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitle', type: 'text', required: false, html: { caption: 'Chart Title', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitlefont', type: 'list', required: false, options: { items: [{id:"arial.ttf",text:"Arial"},{id:"arialbd.ttf",text:"Arial Bold"}, {id:"ariali.ttf",text:"Arial Italic"},{id:"arialbi.ttf",text:"Arial Bold Italic"},{id:"times.ttf",text:"Times New Roman"},{id:"timesbd.ttf",text:"Times New Roman Bold"}, {id:"timesi.ttf",text:"Times New Roman Italic"},{id:"timesbi.ttf",text:"Times New Roman Bold Italic"},{id:"cour.ttf",text:"Courier New"},{id:"courbd.ttf",text:"Courier New Bold"}, {id:"couri.ttf",text:"Courier New Italic"},{id:"courbi.ttf",text:"Courier New Bold Italic"}] },html: { caption: 'Chart Title Font', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitlefontcolor', type: 'color', required: false, html: { caption: 'Chart Title Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitlebgcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitleedgecolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartsubtitleposition', type: 'list', required: false, options: { items:[{id:"1",text:"Bottom Left"}, {id:"2",text:"Bottom Center"}, {id:"3",text:"Bottom Right"}, {id:"4",text:"Left"}, {id:"5",text:"Center"}, {id:"6",text:"Right"}, {id:"7",text:"Top Left"}, {id:"8",text:"Top Center"}, {id:"9",text:"Top Right"}] }, html: { caption: 'Chart Subtitle Position', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartbackgroundcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartaltbackgroundcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartbarcolor_single', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartbarcolor_multi', type: 'text', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartedgecolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'charthgridcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartvgridcolor', type: 'color', required: false, html: { caption: 'Chart Title BG Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold1_linecolor', type: 'color', required: false, html: { caption: 'Chart Thresh 1 Line Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold2_linecolor', type: 'color', required: false, html: { caption: 'Chart Thresh 1 Line Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold3_linecolor', type: 'color', required: false, html: { caption: 'Chart Thresh 1 Line Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold4_linecolor', type: 'color', required: false, html: { caption: 'Chart Thresh 1 Line Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold5_linecolor', type: 'color', required: false, html: { caption: 'Chart Thresh 1 Line Color', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold1_value', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold2_value', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold3_value', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold4_value', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold5_value', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold1_label', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold2_label', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold3_label', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold4_label', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold5_label', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold1_linewidth', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold2_linewidth', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold3_linewidth', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold4_linewidth', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
                  { name: 'chartthreshold5_linewidth', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartdscolx', type: 'text', required: true, html: { caption: 'X Axis Data', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartdscolz', type: 'text', required: false, html: { caption: 'Z Axis Data', attr: 'size="80" maxlength="80"' } },
		  { name: 'chartdscoly', type: 'text', required: true, html: { caption: 'Y Axis Data', attr: 'size="80" maxlength="80"' } }
		],
		records: [
		]
	}

    };
});

