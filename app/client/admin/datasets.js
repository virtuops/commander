define(function (require) {
  var DATA = require('../admin/data')
  var UTILS = require('../../client/utils/misc')
  var MESSAGES = require('../../client/messages/messages');

  var refreshDataSetGrid = function(callback) {
    UTILS.ajaxPost('get', 'dataset', '', function(response) {
      w2ui.datasetgrid.records = response.records
      w2ui.datasetgrid.refresh()

      if (callback) callback()
    })
  }

  return {
    datasetgrid: {
      name: 'datasetgrid',
      header: 'Datasets',
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
            refreshDataSetGrid(function() {
              $('#tb_datasetgrid_toolbar_item_w2ui-reload').w2tag(
                'Grid Reloaded...', { hideOnClick: true, position: 'top' })
            })

          } else if (event.target == 'remove') {
            w2confirm('Are you sure you wish to remove this?')
            .yes(function() {
              // Send all the selected tasks in a list to the server.
              var recids = w2ui.datasetgrid.getSelection()
              var connames = recids.map(function(x) { 
                return UTILS.getRecordFromRecid(x, w2ui.datasetgrid).setname
              })
              connames = "('" + connames.join("','") + "')"
	      console.log(connames);
              UTILS.ajaxPost('delete', 'dataset', [ { setname: connames } ], function(response) { 
                w2ui.datasetgrid.records = response.records
                w2ui.datasetgrid.refresh()
                w2ui.datasetgrid.selectNone()
		MESSAGES.datasetdeleted();
              })
            })
          }
        }
      },
      columns: [
        { field: 'recid', caption: 'RecID', size: '140px', hidden: true, sortable: true },
        { field: 'connectionname', caption: 'Conn Name', size: '80px', sortable: true, hidden: true },
        { field: 'setname', caption: 'Set Name', size: '100%', sortable: true, hidden: false },
        { field: 'query', caption: 'Query', size: '80px', sortable: true, hidden: true },
      ],
      onRender: function(event) {
        event.onComplete = function() { refreshDataSetGrid() }
      },
      onClick: function(event) {
        var grid = this;
        event.onComplete = function () {
          var sel = this.getSelection();
          if (sel.length == 1) {
            w2ui.datasetform.recid  = sel[0];
            w2ui.datasetform.record = $.extend(true, {}, grid.get(sel[0]));
            w2ui.datasetform.refresh();
          } else {
            w2ui.datasetform.clear();
          }
        }
      }
    },
    datasetform: {
      name: 'datasetform',
      header: 'Dataset Config',
      url: 'app/server/main.php',
      method: 'POST',
      show: {
        header         : true,
        toolbar        : true,
        footer        : true
      },
      onRender: function(event){
		event.onComplete = function(){
		    var cons = [];
		    UTILS.ajaxPost('get', 'connection', '', function(response) {
			    response.records.forEach(function(conn){
					cons.push(conn.connectionname);
					if (cons.length == response.total) {
					    w2ui.datasetform.fields[2].options.items = cons;
					    w2ui.datasetform.refresh();
					}
			     })
		    })

		}
      },
      toolbar: {
        items: [
          { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
          { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
        ],
        onClick: function (event) {
          if (event.target == 'clear') w2ui.datasetform.clear();
          if (event.target == 'save') { 
            var record = w2ui.datasetform.record
            // The corresponding part of the record for dropdowns should be objects, but check just in case.
            if (record.connectionname instanceof Object) {
                record.connectionname = record.connectionname.text
	    }

	    	if (record.setname == null) {
			MESSAGES.needdatasetname();
	   	} else {	    
		    UTILS.ajaxPost('save', 'dataset', record, function(response) { 
			  if (response.records.length > 0) {
			  MESSAGES.datasetsaved();
			  w2ui.datasetgrid.records = response.records;
			  w2ui.datasetgrid.refresh();
			  }
		    })
		}
          }
        }
      },
      fields: [
        { name: 'recid', type: 'text', html: { caption: 'ID', attr: 'size="10" readonly' }},
        { name: 'setname', type: 'text', required: true, html: { caption: 'Connection Name', attr: 'size="80" maxlength="80"' } },
	{ name: 'connectionname',  type: 'list', required: true, options: { items: [] }, html: { caption: 'Conns', attr: 'size="40" maxlength="40"' }},
        { name:'query', type: 'text', required: false, html: { caption: 'Query', attr: 'size="80" maxlength="80"' } },
      ],
      record: [
      ]
    },
    init: function(){
      $().w2grid(this.datasetgrid);
      $('#datasetform').w2form(this.datasetform);
    }
  };
});
