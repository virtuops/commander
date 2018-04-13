define(function (require) {
  var DATA = require('../admin/data')
  var UTILS = require('../../client/utils/misc')
  var MESSAGES = require('../../client/messages/messages');

  var refreshMenuGrid = function(callback) {
    UTILS.ajaxPost('get', 'menus', '', function(response) {
      w2ui.menugrid.records = response.records
      w2ui.menugrid.refresh()

      if (callback) callback()
    })
  }


  return {
    menugrid: {
      name: 'menugrid',
      header: 'Menus',
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
            refreshMenuGrid(function() {
              $('#tb_menugrid_toolbar_item_w2ui-reload').w2tag(
                'Grid Reloaded...', { hideOnClick: true, position: 'top' })
            })

          } else if (event.target == 'remove') {
		    w2confirm('Are you sure you wish to remove this?')
		    .yes(function() {
		      // Send all the selected tasks in a list to the server.
		      var recids = w2ui.menugrid.getSelection()
		      var menunames = recids.map(function(x) { 
			return UTILS.getRecordFromRecid(x, w2ui.menugrid).menuname
		      })
		      if (menunames.includes('None')) {
			MESSAGES.cannotdeletenone();
			} else {
			      menunames = "('" + menunames.join("','") + "')"
			      UTILS.ajaxPost('delete', 'menus', [ { menuname: menunames } ], function(response) { 
				w2ui.menugrid.records = response.records
				w2ui.menugrid.refresh()
				w2ui.menugrid.selectNone()
				MESSAGES.menudeleted();
			      })
			}
		    })
          }
        }
      },
      columns: [
        { field: 'recid', caption: 'RecID', size: '140px', hidden: true, sortable: true },
        { field: 'menuname', caption: 'Menu Name', size: '100%', sortable: true, hidden: false },
        { field: 'menutype', caption: 'Menu Type', size: '100%', sortable: true, hidden: false },
        { field: 'menutools', caption: 'Menu Tools', size: '100%', sortable: true, hidden: true },
        { field: 'menuviews', caption: 'Menu Views', size: '100%', sortable: true, hidden: true },
      ],
      onRender: function(event) {
        event.onComplete = function() { refreshMenuGrid() }
      },
      onClick: function(event) {
        var grid = this;
        event.onComplete = function () {
          var sel = this.getSelection();
          if (sel.length == 1) {
            w2ui.menuform.recid  = sel[0];
            w2ui.menuform.record = $.extend(true, {}, grid.get(sel[0]));
	    var menuname = grid.get(sel[0]).menuname;
	    var menutype = grid.get(sel[0]).menutype;
	    var seltools = [];
	    UTILS.ajaxPost('getselected', 'menus', {"menuname": menuname, "menutype":menutype}, function(response) {
		    response.records.forEach(function(toolview){
				if (menutype === 'Tools') {
				seltools.push({"id":toolview.toolname, "text": toolview.toolname});
				if (seltools.length == response.total) {
				    w2ui.menuform.record.menutools = seltools;
				    w2ui.menuform.refresh();
				}
				} else if (menutype === 'Views') {

				seltools.push({"id":toolview.objname, "text": toolview.objname});
				if (seltools.length == response.total) {
				    w2ui.menuform.record.menuviews = seltools;
				    w2ui.menuform.refresh();
				}

				}
		     })
            });

          } else {
            w2ui.menuform.clear();
          }
        }
      }
    },
    menuform: {
      name: 'menuform',
      header: 'Menu Config',
      url: 'app/server/main.php',
      method: 'POST',
      show: {
        header         : true,
        toolbar        : true,
        footer        : true
      },
      toolbar: {
        items: [
          { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
          { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
        ],
        onClick: function (event) {
          if (event.target == 'clear') w2ui.menuform.clear();
          if (event.target == 'save') { 
            var record = w2ui.menuform.record
            // The corresponding part of the record for dropdowns should be objects, but check just in case.

	    	if (record.menuname == null) {
			MESSAGES.needmenuname();
	   	} else {	    
		    UTILS.ajaxPost('save', 'menus', record, function(response) { 
			  if (response.records.length > 0) {
			  MESSAGES.menusaved();
			  w2ui.menugrid.records = response.records;
			  w2ui.menugrid.refresh();
			  }
		    })
		}
          }
        }
      },
      onRender: function(event){
                event.onComplete = function(){
                    var tools = [];
                    var seltools = [];
                    var viewobjs = [];
                    UTILS.ajaxPost('get', 'tools', '', function(response) {
                            response.records.forEach(function(tool){
                                        tools.push(tool.toolname);
                                        if (tools.length == response.total) {
                                            w2ui.menuform.fields[3].options.items = tools;
                                            w2ui.menuform.refresh();
                                        }
                             })
                    })
                    UTILS.ajaxPost('get', 'viewobjects', '', function(response) {
                            response.records.forEach(function(vo){
                                        viewobjs.push(vo.objname);
                                        if (viewobjs.length == response.total) {
                                            w2ui.menuform.fields[4].options.items = viewobjs;
                                            w2ui.menuform.refresh();
                                        }
                             })
                    })
                }
      },
      fields: [
        { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
        { name: 'menuname', type: 'text', required: true, html: { caption: 'Menu Name', attr: 'size="80" maxlength="80"' } },
        { name: 'menutype', type: 'list', required: true, options: {items:['Tools','Views'], openOnFocus: true, selected: [{id:'Tools'}]}, html: { caption: 'Menu Type', attr: 'size="80" maxlength="80"' } },
        { name: 'menutools', type: 'enum', required: false, options: {items: [], openOnFocus: true, selected: []}, html: { caption: 'Tools', attr: 'size="80" maxlength="80"' } },
        { name: 'menuviews', type: 'enum', required: false, options: {items: [], openOnFocus: true, selected: []}, html: { caption: 'Tools', attr: 'size="80" maxlength="80"' } },
      ],
      record: [
      ]
    },
    init: function(){
      $().w2grid(this.menugrid);
      $('#menuform').w2form(this.menuform);
    }
  };
});
