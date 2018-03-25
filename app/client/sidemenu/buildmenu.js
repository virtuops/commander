define(function (require) {
    return {
        buildsidebar: function(userobj){
                var sidebarobj = w2ui.sidebar;
                var allmenu = { id: 'gettingstarted', text: 'Getting Started', icon: 'fa fa-home fa-fw', group: true};
                var allmenunodes =  [ { id: 'intro', text: 'Introduction', img: 'infoicon' }
                                ];
                var adminmenu =  { id: 'admin', text: 'Admin', img: 'icon-folder', group: true };
                var adminmenunodes = [
                                       { id: 'connections', text: 'Connections', img: 'connectionicon' },
                                       { id: 'datasets', text: 'Data Sets', img: 'dataseticon' },
                                       { id: 'users', text: 'Users', img: 'usericon' },
                                       { id: 'groups', text: 'Groups', img: 'usergroupicon' },
                                       { id: 'tools', text: 'Tools', img: 'toolsicon' },
                                       { id: 'menus', text: 'Menus', img: 'menuicon' },
                                       { id: 'viewobjects', text: 'View Objects', img: 'viewobjectsicon' },
                                       { id: 'views', text: 'Views', img: 'viewsicon' },
                                     ];
                var adminusersettingsmenu = { id: 'usersettings', text: 'Settings', group: true, nodes: [
                                        { id: 'settings', text: 'Server Settings', img: 'settingsicon' },
                                        { id: 'helpabout', text: 'About', img: 'infoicon' },
                                        { id: 'logout', text: 'Logout', img: 'logouticon' }
                                        ], group: true, expanded: false };

                var usersettingsmenu = { id: 'usersettings', text: 'Settings', group: true, nodes: [
                                        { id: 'helpabout', text: 'About', img: 'infoicon' },
                                        { id: 'logout', text: 'Logout', img: 'logouticon' }
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

