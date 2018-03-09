define(function () {
    return {
        init: function () {
                $('#layout').w2layout(this.layoutmain);
                $().w2layout(this.layout2080);
                $().w2layout(this.layout5050);
                $().w2layout(this.layout7030);
                $().w2layout(this.layoutMRP);
                $().w2layout(this.layoutsingle);
        },
        layoutmain: {
                name: 'layoutmain',
                panels: [
                        { type: 'left', size: 275, resizable: true },
                        { type: 'main', resizable: true }
                ]
        },
        layout2080: {
                name: 'layout2080',
                panels: [
                        { type: 'top', size: '30%', resizable: true },
                        { type: 'main', size: '70%', resizable: true }
                ]
        },
        layout7030: {
                name: 'layout7030',
                panels: [
                        { type: 'right', size: '30%', resizable: true },
                        { type: 'main', size: '70%', resizable: true }
                ]
        },
        layoutMRP: {
                name: 'layoutMRP',
                panels: [
                        { type: 'main', size: '70%', resizable: true },
                        { type: 'right', size: '30%', resizable: true },
                        { type: 'preview', size: '30%', resizable: true },
                ]
        },
        layout5050: {
                name: 'layout5050',
                panels: [
                        { type: 'left', size: '50%', resizable: true },
                        { type: 'main', size: '50%', resizable: true }
                ]
        },
        layoutsingle: {
                name: 'layoutsingle',
                panels: [
                        { type: 'main', resizable: true }
                ]
        },
	topmain: function(topsize, mainsize) {
		var layout = {
                name: 'topmain',
                panels: [
                	{ type: 'top', size: topsize, resizable: true },
        		{ type: 'main', size: mainsize, resizable: true }
                ]
		};
		return layout;
        },  
	main: {
                name: 'main',
                panels: [
                        { type: 'main', size: '100%', resizable: true }
                ]
        },
	topmainbottom: function(topsize, mainsize, bottomsize) {
		var layout = {
                name: 'topmainbottom',
                panels: [
                        { type: 'top', size: topsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'bottom', size: bottomsize, resizable: true },
                ]
		};
		return layout;
        },
        leftmain: function(leftsize, mainsize, content) {
                var layout = {
                name: 'leftmain',
                panels: [
                        { type: 'left', size: leftsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                ]
                };
                return layout;
        },
        rightmain: function(rightsize, mainsize) {
                var layout = {
                name: 'rightmain',
                panels: [
                        { type: 'right', size: rightsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                ]
                };
                return layout;
        },
        leftmainright: function(leftsize, mainsize, rightsize) {
                var layout = {
                name: 'leftmainright',
                panels: [
                        { type: 'right', size: rightsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'left', size: leftsize, resizable: true },
                ]
                };
                return layout;
        },
        topmainleft: function(topsize, mainsize, leftsize) {
                var layout = {
                name: 'topmainleft',
                panels: [
                        { type: 'top', size: topsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'left', size: leftsize, resizable: true },
                ]
                };
                return layout;
        },
        topmainright: function(topsize, mainsize, rightsize) {
                var layout = {
                name: 'topmainright',
                panels: [
                        { type: 'right', size: rightsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'top', size: topsize, resizable: true },
                ]
                };
                return layout;
        },
        topleftmainbottom: function(topsize, leftsize, mainsize, bottomsize) {
                var layout = {
                name: 'topleftmainbottom',
                panels: [
                        { type: 'left', size: leftsize, resizable: true },
                        { type: 'bottom', size: bottomsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'top', size: topsize, resizable: true },
                ]
                };
                return layout;
        },
        toprightmainpreview: function(topsize, rightsize, mainsize, previewsize) {
                var layout = {
                name: 'toprightmainpreview',
                panels: [
                        { type: 'right', size: rightsize, resizable: true },
                        { type: 'preview', size: previewsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'top', size: topsize, resizable: true },
                ]
                };
                return layout;
        },
        topleftmainpreview: function(topsize, leftsize, mainsize, previewsize) {
                var layout = {
                name: 'topleftmainpreview',
                panels: [
                        { type: 'left', size: leftsize, resizable: true },
                        { type: 'preview', size: previewsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'top', size: topsize, resizable: true },
                ]
                };
                return layout;
        },
        toprightmainpreviewbottom: function(topsize, rightsize, mainsize, previewsize, bottomsize) {
                var layout = {
                name: 'toprightmainpreviewbottom',
                panels: [
                        { type: 'right', size: rightsize, resizable: true },
                        { type: 'preview', size: previewsize, resizable: true },
                        { type: 'bottom', size: bottomsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'top', size: topsize, resizable: true },
                ]
                };
                return layout;
        },
        topleftmainpreviewbottom: function(topsize, leftsize, mainsize, previewsize, bottomsize) {
                var layout = {
                name: 'topleftmainpreviewbottom',
                panels: [
                        { type: 'left', size: leftsize, resizable: true },
                        { type: 'preview', size: previewsize, resizable: true },
                        { type: 'bottom', size: bottomsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'top', size: topsize, resizable: true },
                ]
                };
                return layout;
        },
        all: function(topsize, leftsize, rightsize, mainsize, previewsize, bottomsize) {
                var layout = {
                name: 'all',
                panels: [
                        { type: 'left', size: leftsize, resizable: true },
                        { type: 'right', size: rightsize, resizable: true },
                        { type: 'preview', size: previewsize, resizable: true },
                        { type: 'bottom', size: bottomsize, resizable: true },
                        { type: 'main', size: mainsize, resizable: true },
                        { type: 'top', size: topsize, resizable: true },
                ]
                };
                return layout;
        },
        popuplayout: {
                name: 'popuplayout',
                padding: 4,
                panels: [
                    { type: 'main', size: '100%', minSize: 500 }
                ]
        },
        intro: function(){
                w2ui.layoutmain.load('main','html/docs/intro.php');
        }
    };
});

