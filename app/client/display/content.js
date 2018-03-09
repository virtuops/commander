define(function (require) {
    var Connections = require('../admin/connections');
    var Datasets = require('../admin/datasets');
      var SettingsAdmin = require('../admin/settingsadmin');
    var ToolsAdmin = require('../admin/tools');
    var ViewObjects = require('../admin/viewobjects');
    var Views = require('../admin/views');
    var MenusAdmin = require('../admin/menus');
    var UserAdmin = require('../admin/useradmin');
    var GroupAdmin = require('../admin/groupadmin');

        return {
            init: function(){
                Connections.init();
                Datasets.init();
                ViewObjects.init();
                Views.init();
                SettingsAdmin.init();
                ToolsAdmin.init();
                UserAdmin.init();
                MenusAdmin.init();
                GroupAdmin.init();
            }
        };

});
