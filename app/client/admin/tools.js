define(function (require) {
  var DATA = require('../admin/data')
  var UTILS = require('../../client/utils/misc')
  var MESSAGES = require('../../client/messages/messages');

  var refreshToolGrid = function(callback) {
    UTILS.ajaxPost('get', 'tools', '', function(response) {
      w2ui.toolgrid.records = response.records;
      w2ui.toolgrid.refresh()

      if (callback) callback()
    })
  }

  var getGroups = function (){
        UTILS.ajaxPost('get', 'groups', '', function(response) {
                  var groupnames = [];
                  response.records.forEach(function(group){
                       groupnames.push(group.groupid);
                       if (groupnames.length == response.total) {
                             w2ui.toolform.fields[7].options.items = groupnames;
                             w2ui.toolform.refresh();
                        }
                  })
        })
  }


  return {
    toolgrid: {
      name: 'toolgrid',
      header: 'Tools',
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
            refreshToolGrid(function() {
              $('#tb_toolgrid_toolbar_item_w2ui-reload').w2tag(
                'Grid Reloaded...', { hideOnClick: true, position: 'top' })
            })

          } else if (event.target == 'remove') {
            w2confirm('Are you sure you wish to remove this?')
            .yes(function() {
              // Send all the selected tasks in a list to the server.
              var recids = w2ui.toolgrid.getSelection()
              var toolnames = recids.map(function(x) { 
                return UTILS.getRecordFromRecid(x, w2ui.toolgrid).toolname
              })
              toolnames = "('" + toolnames.join("','") + "')"
              UTILS.ajaxPost('delete', 'tools', [ { toolname: toolnames } ], function(response) { 
                w2ui.toolgrid.records = response.records
                w2ui.toolgrid.refresh()
                w2ui.toolgrid.selectNone()
		MESSAGES.tooldeleted();
              })
            })
          }
        }
      },
      columns: [
        { field: 'recid', caption: 'RecID', size: '140px', hidden: true, sortable: true },
        { field: 'toolname', caption: 'Tool Name', size: '100%', sortable: true, hidden: false },
        { field: 'program', caption: 'Program', size: '200px', sortable: true, hidden: true },
        { field: 'launchurl', caption: 'Launch URL', size: '200px', sortable: true, hidden: true },
        { field: 'everyrow', caption: 'Every Row', size: '200px', sortable: true, hidden: true },
        { field: 'toolfields', caption: 'toolfields', size: '200px', sortable: true, hidden: true },
        { field: 'tooltype', caption: 'Tool Type', size: '200px', sortable: true, hidden: true },
        { field: 'groups', caption: 'Groups', size: '200px', sortable: true, hidden: true },
      ],
      onRender: function(event) {
        event.onComplete = function() { refreshToolGrid() }
      },
      onClick: function(event) {
        var grid = this;
        event.onComplete = function () {
          var sel = this.getSelection();
          if (sel.length == 1) {
            w2ui.toolform.recid  = sel[0];
            w2ui.toolform.record = $.extend(true, {}, grid.get(sel[0]));
            var toolname = grid.get(sel[0]).toolname;
            var groups = [];
            UTILS.ajaxPost('getgroups', 'tools', {"toolname": toolname}, function(response) {
                    response.records.forEach(function(group){
                                groups.push({"id":group.groupid, "text": group.groupid});
                                if (groups.length == response.total) {
                                    w2ui.toolform.record.groups = groups;
                                }
                     })
	    w2ui.toolform.refresh();
            });

          } else {
            w2ui.toolform.clear();
          }
        }
      }
    },
    toolform: {
      name: 'toolform',
      header: 'Tool Config',
      url: 'app/server/main.php',
      method: 'POST',
      show: {
        header         : true,
        toolbar        : true,
        footer        : true
      },
      toolbar: {
        items: [
          { id: 'clear', type: 'button', caption: 'Reset', icon: 'fa fa-file-o' },
          { id: 'save', type: 'button', caption: 'Save', icon: 'fa fa-floppy-o' }
        ],
        onClick: function (event) {
          if (event.target == 'clear') w2ui.toolform.clear();
          if (event.target == 'save') { 
	    record = w2ui.toolform.record;

            // The corresponding part of the record for dropdowns should be objects, but check just in case.

	    	if (record.toolname == null || record.tooltype == null) {
			MESSAGES.needtoolnameortype();
	   	} else {	    
		    UTILS.ajaxPost('save', 'tools', record, function(response) { 
			  if (response.records.length > 0) {
			  MESSAGES.toolsaved();
			  w2ui.toolgrid.records = response.records;
			  w2ui.toolgrid.refresh();
			  }
		    })
		}
          }
        }
      },
      onRender: function(event){
	event.onComplete = function(){
		getGroups();
	}
      },
      fields: [
        { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
        { name: 'toolname', type: 'text', required: true, html: { caption: 'Tool Name', attr: 'size="80" maxlength="80"' } },
        { name:'program', type: 'text', required: false, html: { caption: 'Program', attr: 'size="80" maxlength="80"' } },
        { name:'launchurl', type: 'text', required: false, html: { caption: 'Launch URL', attr: 'size="80" maxlength="80"' } },
        { name:'toolfields', type: 'text', required: false, html: { caption: 'Tool Fields', attr: 'size="80" maxlength="80"' } },
	{ name: 'everyrow', type: 'list', required: false, options: {items: ['true','false'], openOnFocus: true}, html: { caption: 'Every Row', attr: 'size="80" maxlength="80"' } },
	{ name: 'tooltype', type: 'list', required: true, options: {items: ['Program','URL'], openOnFocus: true}, html: { caption: 'Tool Type', attr: 'size="80" maxlength="80"' } },
	{ name: 'groups', type: 'enum', required: true, options: {items: [], openOnFocus: true, selected: []}, html: { caption: 'Groups', attr: 'size="80" maxlength="80"' } },
      ],
      record: [
      ]
    },
    init: function(){
      $().w2grid(this.toolgrid);
      $('#toolform').w2form(this.toolform);
    }
  };
});
