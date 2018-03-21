define(function (require) {
  var DATA = require('../admin/data')
  var UTILS = require('../../client/utils/misc')
  var MESSAGES = require('../../client/messages/messages');

  var refreshConnGrid = function(callback) {
    UTILS.ajaxPost('get', 'connection', '', function(response) {
      w2ui.connectiongrid.records = response.records
      w2ui.connectiongrid.refresh()

      if (callback) callback()
    })
  }

  return {
    connectiongrid: {
      name: 'connectiongrid',
      header: 'Connections',
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
            refreshConnGrid(function() {
              $('#tb_connectiongrid_toolbar_item_w2ui-reload').w2tag(
                'Grid Reloaded...', { hideOnClick: true, position: 'top' })
            })

          } else if (event.target == 'remove') {
            w2confirm('Are you sure you wish to remove this?')
            .yes(function() {
              // Send all the selected tasks in a list to the server.
              var recids = w2ui.connectiongrid.getSelection()
              var connames = recids.map(function(x) { 
                return UTILS.getRecordFromRecid(x, w2ui.connectiongrid).connectionname
              })
              connames = "('" + connames.join("','") + "')"
              UTILS.ajaxPost('delete', 'connection', [ { connectionname: connames } ], function(response) { 
                w2ui.connectiongrid.records = response.records
                w2ui.connectiongrid.refresh()
                w2ui.connectiongrid.selectNone()
		MESSAGES.connectiondeleted();
              })
            })
          }
        }
      },
      columns: [
        { field: 'recid', caption: 'RecID', size: '140px', hidden: true, sortable: true },
        { field: 'connectionname', caption: 'Name', size: '100%', sortable: true, hidden: false },
        { field: 'connectiontype', caption: 'Type', size: '80px', sortable: true, hidden: true },
        { field: 'username', caption: 'User', size: '80px', sortable: true, hidden: true },
        { field: 'password', caption: 'Password', size: '80px', sortable: true, hidden: true },
        { field: 'host', caption: 'Host', size: '80px', sortable: true, hidden: true },
        { field: 'port', caption: 'Port', size: '80px', sortable: true, hidden: true },
        { field: 'url', caption: 'URL', size: '80px', sortable: true, hidden: true },
        { field: 'fileloc', caption: 'File Path', size: '80px', sortable: true, hidden: true },
        { field: 'headers', caption: 'Headers', size: '80px', sortable: true, hidden: true },
        { field: 'description', caption: 'Desc.', size: '80px', sortable: true, hidden: true },
        { field: 'database', caption: 'Database', size: '80px', sortable: true, hidden: true }
      ],
      onRender: function(event) {
        event.onComplete = function() { refreshConnGrid() }
      },
      onClick: function(event) {
        var grid = this;
        event.onComplete = function () {
          var sel = this.getSelection();
          if (sel.length == 1) {
            w2ui.connectionform.recid  = sel[0];
            w2ui.connectionform.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.connectionform.refresh();
          } else {
            w2ui.connectionform.clear();
          }
        }
      }
    },
    connectionform: {
      name: 'connectionform',
      header: 'Connection Config',
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
          if (event.target == 'clear') w2ui.connectionform.clear();
          if (event.target == 'save') { 
            var record = w2ui.connectionform.record
            // The corresponding part of the record for dropdowns should be objects, but check just in case.
            if (record.connectiontype instanceof Object) {
                record.connectiontype = record.connectiontype.text
	    }

	
	    	if (record.connectionname == null) {
			MESSAGES.needconnectionname();
	   	} else {	    
		    UTILS.ajaxPost('save', 'connection', record, function(response) { 
			  if (response.records.length > 0) {
			  MESSAGES.connectionsaved();
			  w2ui.connectiongrid.records = response.records;
			  w2ui.connectiongrid.refresh();
			  }
		    })
		}
          }
        }
      },
      fields: [
        { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
        { name: 'connectionname', type: 'text', required: true, html: { caption: 'Connection Name', attr: 'size="80" maxlength="80"' } },
	{ name: 'connectiontype',  type: 'list', required: true, options: { items: ['CSV','JSON','MySQL','PostgreSQL','RESTXML','RESTJSON','XML' ] }, html: { caption: 'Prog. Language', attr: 'size="40" maxlength="40"' }},
        { name:'username', type: 'text', required: false, html: { caption: 'Username', attr: 'size="80" maxlength="80"' } },
        { name:'password', type: 'text', required: false, html: { caption: 'Password', attr: 'size="80" maxlength="80"' } },
        { name:'host', type: 'text', required: false, html: { caption: 'Host', attr: 'size="80" maxlength="80"' } },
        { name:'port', type: 'text', required: false, html: { caption: 'Port', attr: 'size="80" maxlength="80"' } },
        { name:'database', type: 'text', required: false, html: { caption: 'Database', attr: 'size="80" maxlength="80"' } },
        { name:'url', type: 'text', required: false, html: { caption: 'URL', attr: 'size="280" maxlength="280"' } },
        { name:'fileloc', type: 'text', required: false, html: { caption: 'File Path', attr: 'size="280" maxlength="280"' } },
        { name:'description', type: 'text', required: false, html: { caption: 'Description', attr: 'size="80" maxlength="80"' } },
        { name:'headers', type: 'text', required: false, html: { caption: 'Headers', attr: 'size="80" maxlength="80"' } }
      ],
      records: [
      ]
    },
    init: function(){
      $().w2grid(this.connectiongrid);
      $('#connectionform').w2form(this.connectionform);
    }
  };
});
