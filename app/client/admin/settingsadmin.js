define(function (require) {
    var MESSAGES = require('../../client/messages/messages');
    return {
        settingsbottomform: {
                name: 'settingsbottomform',
                header: 'Global Settings',
                url: 'app/server/main.php',
                postData: {
                        table: 'settings',
                        params: ''
                },
                method: 'POST',
                show: {
                    header         : true,
                    toolbar     : true,
                    footer        : true
                },
                toolbar: {
                        items: [
                                { id: 'clear', type: 'button', caption: 'Reset', img: 'reseticon' },
                                { id: 'save', type: 'button', caption: 'Save', img: 'saveicon' }
                        ],
                        onClick: function (event) {
                                if (event.target == 'clear') w2ui.settingsbottomform.clear();
                                if (event.target == 'save') {
                                        postData = {
                                                table: 'settings',
                                                params: w2ui.settingsbottomform.record
                                        };
                                        w2ui.settingsbottomform.save(postData, function(data){
                                                if (data.status == 'success') {
                                                MESSAGES.settingssaved();
                                                } else {
                                                MESSAGES.settingsnotsaved(data.message);
                                                }
                                        });
                                }

                        }

                },
                fields: [
                  { name: 'dbname', type: 'text', required: true },
                  { name: 'dbhost', type: 'text', required: true },
                  { name: 'dbport', type: 'text', required: true },
                  { name: 'dbuser', type: 'text', required: true },
                  { name: 'basedir', type: 'text', required: true },
                  { name: 'php', type: 'text', required: true },
                  { name: 'weburl', type: 'text', required: true },
                  { name: 'dbpass', type: 'password', required: true },
                  { name: 'ldaphost', type: 'text', required: false },
                  { name: 'ldapport', type: 'text', required: false },
                  { name: 'ldapou', type: 'text', required: false },
                ],
                formHTML: '<div>' +
                '  <div style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; padding:3px;font-weight:bold;color:#777">Database Server</div>' +
                '    <div class="w2ui-group" style="height:195px; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;">' +
                '      <div class="w2ui-field">' +
                '        <label>DB Name: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="dbname" type="text" maxlength="40"></div>' +
                '      </div>' +
                '      <div class="w2ui-field">' +
                '        <label>DB Host: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="dbhost" type="text" maxlength="40"></div>' +
                '      </div>' +
                '      <div class="w2ui-field">' +
                '        <label>DB Port: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="dbport" type="text" maxlength="40"></div>' +
                '      </div>' +
                '      <div class="w2ui-field">' +
                '        <label>DB User: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="dbuser" type="text" maxlength="40"></div>' +
                '      </div>' +
                '      <div class="w2ui-field">' +
                '        <label>DB Pass: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="dbpass" type="password" maxlength="40"></div>' +
                '      </div>' +
                '    </div>' +
                '  </div>' +
                '  <div style="padding:3px;font-weight:bold;color:#777; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;">LDAP Server</div>' +
                '    <div class="w2ui-group" style="height:120px; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;">' +
                '      <div class="w2ui-field">' +
                '        <label>Host: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="ldaphost" type="text" maxlength="64"></div>' +
                '      </div>' +
                '      <div class="w2ui-field">' +
                '        <label>Port: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="ldapport" type="text" maxlength="10"></div>' +
                '      </div>' +
                '      <div class="w2ui-field">' +
                '        <label>Organization: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="ldapou" type="text" maxlength="64"></div>' +
                '      </div>' +
                '    </div>' +
                '  <div style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif; padding:3px; font-weight:bold;color:#777">Environment</div>' +
                '    <div class="w2ui-group" style="height:210px; font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;">' +
                '      <div class="w2ui-field">' +
                '        <label>Base Dir: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="basedir" type="text" maxlength="1024"></div>' +
                '      </div>' +
                '      <div class="w2ui-field">' +
                '        <label>PHP Location: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="php" type="text" maxlength="1024"></div>' +
                '      </div>' +
                '      <div class="w2ui-field">' +
                '        <label>Web URL: </label>' +
                '        <div><input style="font-family: \'Lucida Sans Unicode\', \'Lucida Grande\', sans-serif;" name="weburl" type="text" maxlength="1024"></div>' +
                '      </div>' +
                '    </div>' +
                '  </div>' +
                '</div>',
        },
        readdata: function(){
                var setdata = this.setdata;
                $.post( "app/server/main.php",
                        { cmd: "get", table: "settings", params: "" },
                        function(data){
                                setdata(data);
                });

        },
        setdata: function(data){
                w2ui.settingsbottomform.record = data;
                w2ui.settingsbottomform.refresh();
        },
        init: function(){
                $().w2form(this.settingsbottomform);
                this.readdata();
        }
    };
});

