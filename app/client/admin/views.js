define(function (require) {
  var DATA = require('../admin/data')
  var UTILS = require('../../client/utils/misc')
  var MESSAGES = require('../../client/messages/messages');

  var refreshVGrid = function(callback) {
    UTILS.ajaxPost('get', 'views', '', function(response) {
      w2ui.viewgrid.records = response.records
      w2ui.viewgrid.refresh()

      if (callback) callback()
    })
  }

  var setReadFields = function(canvas){

                if (canvas == 'main') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'all') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
                if (canvas == 'topmain') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'topmainbottom') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'leftmain') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'rightmain') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'leftmainright') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'topmainright') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'topmainleft') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'topleftmainbottom') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
                if (canvas == 'toprightmainpreview') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
                if (canvas == 'topleftmainpreview') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
                if (canvas == 'topleftmainpreviewbottom') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
                if (canvas == 'toprightmainpreviewbottom') {
                        $(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
  }

  var getViewObjs = function (){
                    UTILS.ajaxPost('get', 'viewobjects', '', function(response) {
                    	    var vobjs = [];
                            response.records.forEach(function(vo){
                                        vobjs.push(vo.objname);
                                        if (vobjs.length == response.total) {
                                            w2ui.viewform.fields[4].options.items = vobjs;
                                            w2ui.viewform.fields[6].options.items = vobjs;
                                            w2ui.viewform.fields[8].options.items = vobjs;
                                            w2ui.viewform.fields[10].options.items = vobjs;
                                            w2ui.viewform.fields[12].options.items = vobjs;
                                            w2ui.viewform.fields[14].options.items = vobjs;
                                            var fields = ['toppanel','topsize','bottompanel','bottomsize','rightpanel','rightsize','leftpanel','leftsize','mainpanel','mainsize','previewpanel','previewsize'];
                                            //On render, set all the fields to read only.  User must select a template.
                                            fields.forEach(function(field){
                                            $(w2ui.viewform.get(field).el).prop('readonly', true);
                                            });
                                            }
                                                                                                                                                     })
                      })
  }

  var getGroups = function (){
	UTILS.ajaxPost('get', 'groups', '', function(response) {
                  var groupnames = [];
                  response.records.forEach(function(group){
                       groupnames.push(group.groupid);
                       if (groupnames.length == response.total) {
                             w2ui.viewform.fields[3].options.items = groupnames;
                             w2ui.viewform.refresh();
                        }
                  })
        })
  }

  return {
    viewgrid: {
      name: 'viewgrid',
      header: 'Views',
      show: {
        header : true,
        toolbar : true,
        footer  : true,
        toolbarColumns: false
      },
      toolbar: {
        items: [
          { type: 'break' },
          { type: 'button', id: 'remove', caption: 'Remove', icon: 'fa fa-trash' }
        ],
        onClick: function(event) {
          if (event.target == 'w2ui-reload') {
            refreshVGrid(function() {
              $('#tb_viewgrid_toolbar_item_w2ui-reload').w2tag(
                'Grid Reloaded...', { hideOnClick: true, position: 'top' })
            })

          } else if (event.target == 'remove') {
            w2confirm('Are you sure you wish to remove this?')
            .yes(function() {
              // Send all the selected tasks in a list to the server.
              var recids = w2ui.viewgrid.getSelection()
              var nocnames = recids.map(function(x) { 
                return UTILS.getRecordFromRecid(x, w2ui.viewgrid).nocviewname
              })
              nocnames = "('" + nocnames.join("','") + "')"
              UTILS.ajaxPost('delete', 'views', [ { nocviewname: nocnames } ], function(response) { 
                w2ui.viewgrid.records = response.records
                w2ui.viewgrid.refresh()
                w2ui.viewgrid.selectNone()
		MESSAGES.viewdeleted(nocnames);
              })
            })
          }
        }
      },
      columns: [
        { field: 'recid', caption: 'RecID', size: '140px', hidden: true, sortable: true },
        { field: 'nocviewname', caption: 'Name', size: '100%', sortable: true, hidden: false },
        { field: 'title', caption: 'Title', size: '80px', sortable: true, hidden: true },
        { field: 'groups', caption: 'Groups', size: '80px', sortable: true, hidden: true },
        { field: 'toppanel', caption: 'Top Panel', size: '80px', sortable: true, hidden: true },
        { field: 'topsize', caption: 'Top Panel', size: '80px', sortable: true, hidden: true },
        { field: 'bottompanel', caption: 'Bottom Panel', size: '80px', sortable: true, hidden: true },
        { field: 'bottomsize', caption: 'Bottom Size', size: '80px', sortable: true, hidden: true },
        { field: 'rightpanel', caption: 'Right Panel', size: '80px', sortable: true, hidden: true },
        { field: 'rightsize', caption: 'Right Size', size: '80px', sortable: true, hidden: true },
        { field: 'leftpanel', caption: 'Left Panel', size: '80px', sortable: true, hidden: true },
        { field: 'leftsize', caption: 'Left Size', size: '80px', sortable: true, hidden: true },
        { field: 'previewpanel', caption: 'Preview Panel', size: '80px', sortable: true, hidden: true },
        { field: 'previewsize', caption: 'Preview Size', size: '80px', sortable: true, hidden: true },
        { field: 'mainpanel', caption: 'Main Panel', size: '80px', sortable: true, hidden: true },
        { field: 'mainsize', caption: 'Main Size', size: '80px', sortable: true, hidden: true },
        { field: 'canvasname', caption: 'Canvas Name', size: '80px', sortable: true, hidden: true }
      ],
      onRender: function(event) {
        event.onComplete = function() { 
		refreshVGrid() 
	}
      },
      onClick: function(event) {
        var grid = this;
        event.onComplete = function () {
          var sel = this.getSelection();
          if (sel.length == 1) {
            w2ui.viewform.recid  = sel[0];
            w2ui.viewform.record = $.extend(true, {}, grid.get(sel[0]));
	    var nocviewname = grid.get(sel[0]).nocviewname;
	    var canvasname = grid.get(sel[0]).canvasname;
            UTILS.ajaxPost('getgroups', 'views', {"nocviewname": nocviewname}, function(response) {
            	    var selgroups = [];
                    response.records.forEach(function(group){
                                selgroups.push({"id":group.groupid, "text": group.groupid});
                                if (selgroups.length == response.total) {
                                    w2ui.viewform.record.groups = selgroups;
                                }
                     })
		     setReadFields(canvasname);
		     w2ui.viewform.refresh();
            });
          } else {
            //w2ui.viewform.clear();
          }
        }
      }
    },
    viewform: {
      name: 'viewform',
      header: 'View Config',
      url: 'app/server/main.php',
      method: 'POST',
      show: {
        header         : true,
        toolbar        : true,
        footer        : true
      },
      tabs: [
            { id: 'tab1', caption: 'Layout' },
            { id: 'tab2', caption: 'Objects'}
      ],
      toolbar: {
        items: [
          { id: 'clear', type: 'button', caption: 'Reset', icon: 'fa fa-file-o' },
          { id: 'save', type: 'button', caption: 'Save', icon: 'fa fa-floppy-o' }
        ],
        onClick: function (event) {
          if (event.target == 'clear') w2ui.viewform.clear();
          if (event.target == 'save') { 
            var record = w2ui.viewform.record
            // The corresponding part of the record for dropdowns should be objects, but check just in case.

                if (typeof record.toppanel !== 'undefined') { record.toppanel = record.toppanel.text }
                if (typeof record.bottompanel !== 'undefined') {record.bottompanel = record.bottompanel.text}
                if (typeof record.leftpanel !== 'undefined') {record.leftpanel = record.leftpanel.text}
                if (typeof record.rightpanel !== 'undefined') {record.rightpanel = record.rightpanel.text}
                if (typeof record.mainpanel !== 'undefined') {record.mainpanel = record.mainpanel.text}
                if (typeof record.previewpanel !== 'undefined') {record.previewpanel = record.previewpanel.text}
                if (typeof record.topsize !== 'undefined') {record.topsize = record.topsize.text}
                if (typeof record.bottomsize !== 'undefined') {record.bottomsize = record.bottomsize.text}
                if (typeof record.leftsize !== 'undefined') {record.leftsize = record.leftsize.text}
                if (typeof record.rightsize !== 'undefined') {record.rightsize = record.rightsize.text}
                if (typeof record.mainsize !== 'undefined') {record.mainsize = record.mainsize.text}
                if (typeof record.previewsize !== 'undefined') {record.previewsize = record.previewsize.text}

	
	    	if (record.nocviewname == null) {
			MESSAGES.needviewname();
	   	} else {	    
		    UTILS.ajaxPost('save', 'views', record, function(response) { 
			  if (response.records.length > 0) {
			  MESSAGES.viewsaved();
			  w2ui.viewgrid.records = response.records;
			  w2ui.viewgrid.refresh();
			  }
		    })
		}
          }
        }
      },
      onChange: function(event){

		if (event.target == 'canvasname' && event.value_new == 'main') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);	
			$(w2ui.viewform.get('mainsize').el).prop('readonly', false);	
			$(w2ui.viewform.get('toppanel').el).prop('readonly', true);	
			$(w2ui.viewform.get('topsize').el).prop('readonly', true);	
			$(w2ui.viewform.get('rightpanel').el).prop('readonly', true);	
			$(w2ui.viewform.get('rightsize').el).prop('readonly', true);	
			$(w2ui.viewform.get('leftpanel').el).prop('readonly', true);	
			$(w2ui.viewform.get('leftsize').el).prop('readonly', true);	
			$(w2ui.viewform.get('bottompanel').el).prop('readonly', true);	
			$(w2ui.viewform.get('bottomsize').el).prop('readonly', true);	
			$(w2ui.viewform.get('previewpanel').el).prop('readonly', true);	
			$(w2ui.viewform.get('previewsize').el).prop('readonly', true);	
		}
		if (event.target == 'canvasname' && event.value_new == 'all') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
		if (event.target == 'canvasname' && event.value_new == 'topmain') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
		if (event.target == 'canvasname' && event.value_new == 'topmainbottom') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
		if (event.target == 'canvasname' && event.value_new == 'leftmain') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
		if (event.target == 'canvasname' && event.value_new == 'rightmain') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
		if (event.target == 'canvasname' && event.value_new == 'leftmainright') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
		if (event.target == 'canvasname' && event.value_new == 'topmainright') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
		if (event.target == 'canvasname' && event.value_new == 'topmainleft') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
		if (event.target == 'canvasname' && event.value_new == 'topleftmainbottom') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', true);
                }
		if (event.target == 'canvasname' && event.value_new == 'toprightmainpreview') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
		if (event.target == 'canvasname' && event.value_new == 'topleftmainpreview') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
		if (event.target == 'canvasname' && event.value_new == 'topleftmainpreviewbottom') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }
		if (event.target == 'canvasname' && event.value_new == 'toprightmainpreviewbottom') {
			$(w2ui.viewform.get('mainpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('mainsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('toppanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('topsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('rightsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('leftpanel').el).prop('readonly', true);
                        $(w2ui.viewform.get('leftsize').el).prop('readonly', true);
                        $(w2ui.viewform.get('bottompanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('bottomsize').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewpanel').el).prop('readonly', false);
                        $(w2ui.viewform.get('previewsize').el).prop('readonly', false);
                }

      },
      onRender: function(event){
                event.onComplete = function(){

			$(function(){$('input#nocviewname').on({
            		keydown: function(e) {
              		if (e.which === 32)
                		return false;
            		},
            		change: function() {
              		this.value = this.value.replace(/\s/g, "");
            		}
          		});})

			getViewObjs();
			getGroups();
                }
      },
      fields: [
        { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
        { name: 'nocviewname', type: 'text', required: true, html: { caption: 'View Name', attr: 'size="80" maxlength="80"' } },
        { name:'title', type: 'text', required: false, html: { caption: 'Title', attr: 'size="280" maxlength="280"' } },
	{ name: 'groups', type: 'enum', required: false, options: {items: [], openOnFocus: true, selected: []}, html: { caption: 'Groups', attr: 'size="80" maxlength="80"' } },
        { name:'toppanel', type: 'list', required: false, options: { items: [] }, html: { caption: 'Top Size', attr: 'size="40" maxlength="40"' }},
        { name:'topsize', type: 'list', required: false, options: { items: [ '0%','10%','20%','30%','40%','50%','60%','70%','80%','90%','100%' ] }, html: { caption: 'Top Size', attr: 'size="40" maxlength="40"' }},
        { name:'bottompanel', type: 'list', required: false, options: { items: [] }, html: { caption: 'Bottom Panel', attr: 'size="40" maxlength="40"' }},
        { name:'bottomsize', type: 'list', required: false, options: { items: [ '0%','10%','20%','30%','40%','50%','60%','70%','80%','90%','100%' ] }, html: { caption: 'Bottom Size', attr: 'size="40" maxlength="40"' }},
        { name:'mainpanel', type: 'list', required: false, options: { items: [] }, html: { caption: 'Bottom Panel', attr: 'size="40" maxlength="40"' }},
        { name:'mainsize', type: 'list', required: false, options: { items: [ '0%','10%','20%','30%','40%','50%','60%','70%','80%','90%','100%' ] }, html: { caption: 'Bottom Size', attr: 'size="40" maxlength="40"' }},
        { name:'previewpanel', type: 'list', required: false, options: { items: [] }, html: { caption: 'Bottom Panel', attr: 'size="40" maxlength="40"' }},
        { name:'previewsize', type: 'list', required: false, options: { items: [ '0%','10%','20%','30%','40%','50%','60%','70%','80%','90%','100%' ] }, html: { caption: 'Bottom Size', attr: 'size="40" maxlength="40"' }},
        { name:'leftpanel', type: 'list', required: false, options: { items: [] }, html: { caption: 'Bottom Panel', attr: 'size="40" maxlength="40"' }},
        { name:'leftsize', type: 'list', required: false, options: { items: [ '0%','10%','20%','30%','40%','50%','60%','70%','80%','90%','100%' ] }, html: { caption: 'Bottom Size', attr: 'size="40" maxlength="40"' }},
        { name:'rightpanel', type: 'list', required: false, options: { items: [] }, html: { caption: 'Bottom Panel', attr: 'size="40" maxlength="40"' }},
        { name:'rightsize', type: 'list', required: false, options: { items: [ '0%','10%','20%','30%','40%','50%','60%','70%','80%','90%','100%' ] }, html: { caption: 'Bottom Size', attr: 'size="40" maxlength="40"' }},
        { name:'canvasname', type: 'radio', required: false, html: { caption: 'Canvas Name', attr: 'size="280" maxlength="280"' } }
      ],
      records: [
      ]
    },
    init: function(){
      $().w2grid(this.viewgrid);
      $('#viewform').w2form(this.viewform);
    }
  };
});
