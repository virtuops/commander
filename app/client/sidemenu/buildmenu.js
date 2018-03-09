define(function (require) {
    return {
        buildsidebar: function(userobj){
                var sidebarobj = w2ui.sidebar;
                var allmenu = { id: 'gettingstarted', text: 'Getting Started', icon: 'fa fa-home fa-fw', group: true};
                var allmenunodes =  [ { id: 'intro', text: 'Introduction' }
                                ];
                var adminmenu =  { id: 'admin', text: 'Admin', img: 'icon-folder', group: true };
                var adminmenunodes = [
                                       { id: 'connections', text: 'Connections' },
                                       { id: 'datasets', text: 'Data Sets' },
                                       { id: 'users', text: 'Users' },
                                       { id: 'groups', text: 'Groups' },
                                       { id: 'tools', text: 'Tools' },
                                       { id: 'menus', text: 'Menus' },
                                       { id: 'viewobjects', text: 'View Objects' },
                                       { id: 'views', text: 'Views' },
                                     ];
                var adminusersettingsmenu = { id: 'usersettings', text: 'Settings', group: true, nodes: [
                                        { id: 'settings', text: 'Server Settings' },
                                        { id: 'helpabout', text: 'About' },
                                        { id: 'logout', text: 'Logout' }
                                        ], group: true, expanded: false };

                var usersettingsmenu = { id: 'usersettings', text: 'Settings', group: true, nodes: [
                                        { id: 'helpabout', text: 'About' },
                                        { id: 'logout', text: 'Logout' }
                                        ], group: true, expanded: false };
		
		
		var myviewsmenu = { id: 'myviewsmenu', text: 'MyViews', group: true, nodes: [
			], group: true, expanded: false };


                //Add intro and getting started stuff
                sidebarobj.add(allmenu);
                sidebarobj.add('gettingstarted', allmenunodes);

                if (userobj.username === 'admin') {
                        sidebarobj.add(adminmenu);
                        sidebarobj.add(myviewsmenu);
                        sidebarobj.add('admin',adminmenunodes);
                        sidebarobj.add(adminusersettingsmenu);
                        sidebarobj.refresh();
                } else {
			sidebarobj.add(myviewsmenu);
                        sidebarobj.add(usersettingsmenu);
                }
        }
    };
});

