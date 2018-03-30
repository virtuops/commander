define(function (require) {

        var UTILS = require('../../client/utils/misc');
        var MESSAGES = require('../../client/messages/messages');

    return {
        launch: function(){

        var config = {
	    layout: {
		name: 'poplayout',
		padding: 4,
		panels: [
		    { type: 'main', minSize: 300 }
		]
	    },
	    form: {
		show: {
			header: "false"
		},
		name: 'listconfigform',
		fields: [
			{ field: 'objtype', type: 'list', options: { items: ['Grid','IFrame','HTML','Chart/Graph'] }},
			{ field: 'chartcategory', type: 'list', options: { items: ['Bar','Area','Line','Pie','Gauge','Meter','Pyramid/Cone/Funnel'] }},
		],
		onChange: function(event){
			console.log(event);
			if (event.value_new.id == 'Chart/Graph') {
			document.getElementById('chartcategory').readOnly = false;
			}
		},
		toolbar: {
		    items: [
			{ id: 'load', type: 'button', caption: 'Load', img: 'loadvotype' }
		    ],
		    onClick: function (event) {
			if (event.target == 'load') {
	
			 	if (w2ui.listconfigform.record.objtype.text == 'Grid') {
				w2ui.layout7030.content('main',w2ui.viewobjectform);
				}
			 	if (w2ui.listconfigform.record.objtype.text == 'IFrame') {
				w2ui.layout7030.content('main',w2ui.viewobjectform_iframe);
				}
			 	if (w2ui.listconfigform.record.objtype.text == 'HTML') {
				w2ui.layout7030.content('main',w2ui.viewobjectform_html);
				}
			 	if (w2ui.listconfigform.record.objtype.text == 'Chart/Graph') {
					if (w2ui.listconfigform.record.chartcategory.text == 'Bar') {
					w2ui.layout7030.content('main',w2ui.viewobjectform_bar);
					}
					if (w2ui.listconfigform.record.chartcategory.text == 'Area') {
					w2ui.layout7030.content('main',w2ui.viewobjectform_area);
					}
					if (w2ui.listconfigform.record.chartcategory.text == 'Pie') {
					w2ui.layout7030.content('main',w2ui.viewobjectform_pie);
					}
					if (w2ui.listconfigform.record.chartcategory.text == 'Gauge') {
					w2ui.layout7030.content('main',w2ui.viewobjectform_gauge);
					}
					if (w2ui.listconfigform.record.chartcategory.text == 'Meter') {
					w2ui.layout7030.content('main',w2ui.viewobjectform_meter);
					}
					if (w2ui.listconfigform.record.chartcategory.text == 'Pyramid/Cone/Funnel') {
					w2ui.layout7030.content('main',w2ui.viewobjectform_pyramid);
					}
					if (w2ui.listconfigform.record.chartcategory.text == 'Line') {
					w2ui.layout7030.content('main',w2ui.viewobjectform_line);
					}
				}
				w2popup.close();
			}
		    }
        	},
		formHTML: '<div class="w2ui-page page-0">' +
			'<div class="w2ui-field">'+
				'<label>Object Type:</label>'+
				'<div>'+
				'<input name="objtype" type="text" maxlength="300" size="60" />'+
				'</div>'+
			'</div>'+
                        '<div class="w2ui-field">'+
                                '<label>Chart Type:</label>'+
                                '<div>'+
                                '<input id="chartcategory" name="chartcategory" type="text" maxlength="300" size="60" readonly/>'+
                                '</div>'+
                        '</div>'+
			'</div>',
		record: {
		}
    }
};


        $(function () {
            // initialization in memory
            if (w2ui.poplayout) { w2ui.poplayout.destroy(); }
            if (w2ui.listconfigform) { w2ui.listconfigform.destroy(); }
            $().w2layout(config.layout);
            $().w2form(config.form);
	    showFlows();
        });


            var showFlows = function(){
            w2popup.open({
                title   : 'Load a Config',
                width   : 600,
                height  : 300,
                showMax : true,
                body    : '<div id="main" style="position: absolute; left: 0px; top: 0px; right: 0px; bottom: 0px;"></div>',
                onOpen  : function (event) {
                    event.onComplete = function () {
                        $('#w2ui-popup #main').w2render('poplayout');
                        w2ui.poplayout.content('main', w2ui.listconfigform);
                    }
                },
                onToggle: function (event) {
                    event.onComplete = function () {
                        w2ui.poplayout.resize();
                    }
                }
            });
            };

        }
    };
});

