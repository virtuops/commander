/*START OF PROGRAM*/

define(function (require) {
    var Commander = require('../app/client/mainview/layout');
    var SideBar = require('../app/client/sidemenu/menu');
    var Content = require('../app/client/display/content');
    var Session = require('../app/client/utils/session');
    Commander.init();
    SideBar.init();
    Commander.intro();
    Content.init();
    Session.init();

});

