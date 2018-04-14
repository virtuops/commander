define(function (require) {
 var DATA = require('../admin/data')
  var UTILS = require('../../client/utils/misc')
  var LISTCONFIGS = require('../admin/listconfigs')
  var BAR = require('../admin/bar')
  var AREA = require('../admin/area')
  var PIE = require('../admin/pie')
  var PYRAMID = require('../admin/pyramid')
  var GAUGE = require('../admin/gauge')
  var METER = require('../admin/meter')
  var LINE = require('../admin/line')
  var MESSAGES = require('../../client/messages/messages');

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

  var refreshVOGrid = function(callback) {
    UTILS.ajaxPost('get', 'viewobjects', '', function(response) {
      w2ui.viewobjectgrid.records = response.records
      w2ui.viewobjectgrid.refresh()

      if (callback) callback()
    })
  }

  return {
    viewobjectgrid: {
      name: 'viewobjectgrid',
      header: 'View Objects',
      show: {
        header : true,
        toolbar : true,
        footer  : true,
        toolbarColumns: false
      },
      toolbar: {
        items: [
          { type: 'break' },
          { type: 'button', id: 'remove', caption: 'Remove', img: 'removeicon' }
        ],
        onClick: function(event) {
          if (event.target == 'w2ui-reload') {
            refreshVOGrid(function() {
              $('#tb_viewobjectgrid_toolbar_item_w2ui-reload').w2tag(
                'Grid Reloaded...', { hideOnClick: true, position: 'top' })
            })

          } else if (event.target == 'remove') {
            w2confirm('Are you sure you wish to remove this?')
            .yes(function() {
              // Send all the selected tasks in a list to the server.
              var recids = w2ui.viewobjectgrid.getSelection()
              var vonames = recids.map(function(x) { 
                return UTILS.getRecordFromRecid(x, w2ui.viewobjectgrid).objname
              })
              vonames = "('" + vonames.join("','") + "')"
              UTILS.ajaxPost('delete', 'viewobjects', [ { objname: vonames } ], function(response) { 
                w2ui.viewobjectgrid.records = response.records
                w2ui.viewobjectgrid.refresh()
                w2ui.viewobjectgrid.selectNone()
		MESSAGES.viewobjectdeleted();
              })
            })
          }
        }
      },
      columns: [
        { field: 'recid', caption: 'RecID', size: '140px', hidden: true, sortable: true },
        { field: 'objname', caption: 'Name', size: '100%', sortable: true, hidden: false },
        { field: 'objtype', caption: 'Type', size: '80px', sortable: true, hidden: true },
        { field: 'objurl', caption: 'URL', size: '80px', sortable: true, hidden: true },
        { field: 'objmarkup', caption: 'Markup', size: '80px', sortable: true, hidden: true },
        { field: 'gridcolumns', caption: 'Grid Cols', size: '80px', sortable: true, hidden: true },
        { field: 'reststartproperty', caption: 'REST Start Prop.', size: '80px', sortable: true, hidden: true },
        { field: 'colformat', caption: 'Formatting', size: '80px', sortable: true, hidden: true },
        { field: 'refreshrate', caption: 'Refresh Rate', size: '80px', sortable: true, hidden: true },
        { field: 'toolbarmenu', caption: 'Toolbar Menu', size: '80px', sortable: true, hidden: true },
        { field: 'viewmenu', caption: 'View Menu', size: '80px', sortable: true, hidden: true },
        { field: 'contextmenu', caption: 'Context Menu', size: '80px', sortable: true, hidden: true },
        { field: 'charttype', caption: 'Chart Type', size: '80px', sortable: true, hidden: true },
        { field: 'setname', caption: 'Dataset', size: '80px', sortable: true, hidden: true }
      ],
      onRender: function(event) {
        event.onComplete = function() { refreshVOGrid() }
      },
      onClick: function(event) {
        var grid = this;
        event.onComplete = function () {
          var sel = this.getSelection();
	  var selrecord = grid.get(sel[0]);
          if (sel.length == 1 && selrecord.objtype == 'grid') {
	    w2ui.layout7030.content('main',w2ui.viewobjectform);
	    setTimeout(function(){
            w2ui.viewobjectform.recid  = sel[0];
            w2ui.viewobjectform.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform.refresh();
	    }, 1000);

          } else if (sel.length == 1 && selrecord.objtype == 'iframe') {
	    w2ui.layout7030.content('main',w2ui.viewobjectform_iframe);
	    setTimeout(function(){
            w2ui.viewobjectform_iframe.recid  = sel[0];
            w2ui.viewobjectform_iframe.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_iframe.refresh();
	    }, 1000);

	  } else if (sel.length == 1 && selrecord.objtype == 'html') {
	    w2ui.layout7030.content('main',w2ui.viewobjectform_html);
	    setTimeout(function(){
            w2ui.viewobjectform_html.recid  = sel[0];
            w2ui.viewobjectform_html.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_html.refresh();
	    },1000);

	  } else if (sel.length == 1 && selrecord.objtype == 'chart' && selrecord.charttype == 'bar' ) {

	    w2ui.layout7030.content('main',w2ui.viewobjectform_bar);
	    setTimeout(function(){
            w2ui.viewobjectform_bar.recid  = sel[0];
            w2ui.viewobjectform_bar.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_bar.refresh();
	    },1000);

          } else if (sel.length == 1 && selrecord.objtype == 'chart' && selrecord.charttype == 'area' ) {

            w2ui.layout7030.content('main',w2ui.viewobjectform_area);
            setTimeout(function(){
            w2ui.viewobjectform_area.recid  = sel[0];
            w2ui.viewobjectform_area.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_area.refresh();
            },1000);


	  } else if (sel.length == 1 && selrecord.objtype == 'chart' && selrecord.charttype == 'pie' ) {

	    w2ui.layout7030.content('main',w2ui.viewobjectform_pie);
	    setTimeout(function(){
            w2ui.viewobjectform_pie.recid  = sel[0];
            w2ui.viewobjectform_pie.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_pie.refresh();
	    },1000);

	  } else if (sel.length == 1 && selrecord.objtype == 'chart' && selrecord.charttype == 'gauge' ) {

	    w2ui.layout7030.content('main',w2ui.viewobjectform_gauge);
	    setTimeout(function(){
            w2ui.viewobjectform_gauge.recid  = sel[0];
            w2ui.viewobjectform_gauge.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_gauge.refresh();
	    },1000);

	  } else if (sel.length == 1 && selrecord.objtype == 'chart' && selrecord.charttype == 'meter' ) {

	    w2ui.layout7030.content('main',w2ui.viewobjectform_meter);
	    setTimeout(function(){
            w2ui.viewobjectform_meter.recid  = sel[0];
            w2ui.viewobjectform_meter.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_meter.refresh();
	    },1000);

	  } else if (sel.length == 1 && selrecord.objtype == 'chart' && selrecord.charttype == 'pyramid' ) {

	    w2ui.layout7030.content('main',w2ui.viewobjectform_pyramid);
	    setTimeout(function(){
            w2ui.viewobjectform_pyramid.recid  = sel[0];
            w2ui.viewobjectform_pyramid.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_pyramid.refresh();
	    },1000);

	  } else if (sel.length == 1 && selrecord.objtype == 'chart' && selrecord.charttype == 'line' ) {

	    w2ui.layout7030.content('main',w2ui.viewobjectform_line);
	    setTimeout(function(){
            w2ui.viewobjectform_line.recid  = sel[0];
            w2ui.viewobjectform_line.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.viewobjectform_line.refresh();
	    },1000);
	
	  } else {

            w2ui.viewobjectform.clear();
            w2ui.viewobjectform_iframe.clear();
            w2ui.viewobjectform_html.clear();
            w2ui.viewobjectform_bar.clear();
            w2ui.viewobjectform_pie.clear();
            w2ui.viewobjectform_gauge.clear();
            w2ui.viewobjectform_line.clear();

          }
        }
      }
    },
    viewobjectform: {
      name: 'viewobjectform',
      header: 'View Object Config Grid',
      url: 'app/server/main.php',
      method: 'POST',
      show: {
        header         : true,
        toolbar        : true,
        footer        : true
      },
      toolbar: {
        items: [
          { id: 'new', type: 'button', caption: 'New', img: 'newicon' },
          { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
          { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
        ],
        onClick: function (event) {
          if (event.target == 'clear') w2ui.viewobjectform.clear();
	  if (event.target == 'new') {
		LISTCONFIGS.launch();
	  }
          if (event.target == 'save') { 
            var record = w2ui.viewobjectform.record
            // The corresponding part of the record for dropdowns should be objects, but check just in case.
	    record.objtype = 'grid';
            if (record.setname instanceof Object) {
                record.setname = record.setname.text
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
			getDS(w2ui.viewobjectform, w2ui.viewobjectform.fields[2]);
			getToolMenus(w2ui.viewobjectform, w2ui.viewobjectform.fields[7]);
			getToolMenus(w2ui.viewobjectform, w2ui.viewobjectform.fields[8]);
			getViewMenus(w2ui.viewobjectform, w2ui.viewobjectform.fields[9]);
                }
      },
      fields: [
        { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
        { name: 'objname', type: 'text', required: true, html: { caption: 'Object Name', attr: 'size="80" maxlength="80"' } },
	{ name: 'setname',  type: 'list', required: true, options: { items: [] }, html: { caption: 'Obj. Type', attr: 'size="40" maxlength="40"' }},
        { name: 'gridcolumns', type: 'text', required: true, html: { caption: 'Grid Cols', attr: 'size="80" maxlength="80"' } },
        { name: 'colformat', type: 'text', required: false, html: { caption: 'Col Format', attr: 'size="80" maxlength="80"' } },
        { name: 'refreshrate', type: 'int', required: false, html: { caption: 'Refresh Rate', attr: 'size="80" maxlength="80"' } },
        { name: 'reststartproperty', type: 'text', required: false, html: { caption: 'Rest Start Prop', attr: 'size="80" maxlength="80"' } },
	{ name: 'toolbarmenu',  type: 'list', required: false, options: { items: [] }, html: { caption: 'Toolbar Menu', attr: 'size="40" maxlength="40"' }},
	{ name: 'contextmenu',  type: 'list', required: false, options: { items: [] }, html: { caption: 'Context Menu', attr: 'size="40" maxlength="40"' }},
	{ name: 'viewmenu',  type: 'list', required: false, options: { items: [] }, html: { caption: 'View Menu', attr: 'size="40" maxlength="40"' }},
      ],
      records: [
      ]
    },

    viewobjectform_bar: BAR.bar,
    viewobjectform_area: AREA.area,
    viewobjectform_pie: PIE.pie,
    viewobjectform_gauge: GAUGE.gauge,
    viewobjectform_meter: METER.meter,
    viewobjectform_pyramid: PYRAMID.pyramid,
    viewobjectform_line: LINE.line,

    viewobjectform_iframe: {
      name: 'viewobjectform_iframe',
      header: 'View Object Config IFrame',
      url: 'app/server/main.php',
      method: 'POST',
      show: {
        header         : true,
        toolbar        : true,
        footer        : true
      },
      toolbar: {
        items: [
          { id: 'new', type: 'button', caption: 'New', img: 'newicon' },
          { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
          { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
        ],
        onClick: function (event) {
          if (event.target == 'clear') w2ui.viewobjectform_iframe.clear();
          if (event.target == 'new') {
		LISTCONFIGS.launch();
          }
          if (event.target == 'save') {

            var record = w2ui.viewobjectform_iframe.record
	    if (record.toolbarmenu instanceof Object) {
                record.toolbarmenu = record.toolbarmenu.text
            }
            // The corresponding part of the record for dropdowns should be objects, but check just in case.
	    record.objtype = 'iframe';
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
			getToolMenus(w2ui.viewobjectform_iframe, w2ui.viewobjectform_iframe.fields[3]);
			getViewMenus(w2ui.viewobjectform_iframe, w2ui.viewobjectform_iframe.fields[4]);
		}
      },
      fields: [
        { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
        { name: 'objname', type: 'text', required: true, html: { caption: 'Object Name', attr: 'size="80" maxlength="80"' } },
        { name:'objurl', type: 'text', required: true, html: { caption: 'URL', attr: 'size="280" maxlength="280"' } },
	{ name: 'toolbarmenu',  type: 'list', required: false, options: { items: [] }, html: { caption: 'Toolbar Menu', attr: 'size="40" maxlength="40"' }},
	{ name: 'viewmenu',  type: 'list', required: false, options: { items: [] }, html: { caption: 'View Menu', attr: 'size="40" maxlength="40"' }},
      ],
      records: [
      ]
    },

    viewobjectform_html: {
      name: 'viewobjectform_html',
      header: 'View Object Config HTML',
      url: 'app/server/main.php',
      method: 'POST',
      show: {
        header         : true,
        toolbar        : true,
        footer        : true
      },
      toolbar: {
        items: [
          { id: 'new', type: 'button', caption: 'New', img: 'newicon' },
          { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
          { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
        ],
        onClick: function (event) {
          if (event.target == 'clear') w2ui.viewobjectform_html.clear();
          if (event.target == 'new') {
		LISTCONFIGS.launch();
          }
          if (event.target == 'save') {
            var record = w2ui.viewobjectform_html.record
	    if (record.toolbarmenu instanceof Object) {
                record.toolbarmenu = record.toolbarmenu.text
            }
            // The corresponding part of the record for dropdowns should be objects, but check just in case.
	    record.objtype = 'html';
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
			w2ui.viewobjectform_html.fields[3].options.items = [];
                        getToolMenus(w2ui.viewobjectform_html, w2ui.viewobjectform_html.fields[3]);
                        getViewMenus(w2ui.viewobjectform_html, w2ui.viewobjectform_html.fields[4]);
                }
      },
      fields: [
        { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
        { name: 'objname', type: 'text', required: true, html: { caption: 'Object Name', attr: 'size="80" maxlength="80"' } },
        { name:'objmarkup', type: 'text', required: true, html: { caption: 'Markup', attr: 'size="280" maxlength="280"' } },
	{ name: 'toolbarmenu',  type: 'list', required: false, options: { items: [] }, html: { caption: 'Toolbar Menu', attr: 'size="40" maxlength="40"' }},
	{ name: 'viewmenu',  type: 'list', required: false, options: { items: [] }, html: { caption: 'View Menu', attr: 'size="40" maxlength="40"' }},
      ],
      records: [
      ]
    },
    init: function(){
      $('#viewobjectform').w2form(this.viewobjectform);
      $('#viewobjectform_iframe').w2form(this.viewobjectform_iframe);
      $('#viewobjectform_html').w2form(this.viewobjectform_html);
      $('#viewobjectform_bar').w2form(this.viewobjectform_bar);
      $('#viewobjectform_area').w2form(this.viewobjectform_area);
      $('#viewobjectform_pie').w2form(this.viewobjectform_pie);
      $('#viewobjectform_gauge').w2form(this.viewobjectform_gauge);
      $('#viewobjectform_meter').w2form(this.viewobjectform_meter);
      $('#viewobjectform_pyramid').w2form(this.viewobjectform_pyramid);
      $('#viewobjectform_line').w2form(this.viewobjectform_line);
      $().w2grid(this.viewobjectgrid);
    }
  };
});
