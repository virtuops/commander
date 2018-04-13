<?php

require_once 'Settings.php';
require_once __DIR__.'/../utils/Log.php';

Class ViewObjects {

        private $l;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function ViewObjectOperation($action, $params, $con)
        {
                if ($action == 'save') {
                        $this->CreateUpdate($params, $con);
                } else if ($action == 'get') {
                        $this->Read($params, $con);
                } else if ($action == 'getcontent') {
                        $this->ReadContent($params, $con);
                } else if ($action == 'delete') {
                        $this->Delete($params, $con);
                }
        }

        private function CreateUpdate($params, $con)
        {

                $objname = $params['objname'];
                $objtype = isset($params['objtype']) ? $params['objtype'] : '';
                $setname = isset($params['setname']) ? $params['setname'] : '';
                $refreshrate = isset($params['refreshrate']) ? $params['refreshrate'] : '60';
                $reststartproperty = isset($params['reststartproperty']) ? $params['reststartproperty'] : '';
                $objurl = isset($params['objurl']) ? $params['objurl'] : '';
                $objmarkup = isset($params['objmarkup']) ? $params['objmarkup'] : '';
                $gridcolumns = isset($params['gridcolumns']) ? $params['gridcolumns'] : '';
                $colformat = isset($params['colformat']) ? $params['colformat'] : '';
                $toolbarmenu = isset($params['toolbarmenu']) ? $params['toolbarmenu'] : '';
                $contextmenu = isset($params['contextmenu']) ? $params['contextmenu'] : '';
		$chartwidth = isset($params['chartwidth']) ? $params['chartwidth'] : '200'; 
              	$chartheight = isset($params['chartheight']) ? $params['chartheight'] : '200'; 
              	$chartpieradius = isset($params['chartpieradius']) ? $params['chartpieradius'] : 100; 
              	$chartpyramidsize = isset($params['chartpyramidsize']) ? $params['chartpyramidsize'] : 100; 
              	$chartpielabels = isset($params['chartpielabels']) ? $params['chartpielabels'] : 'Normal'; 
              	$chartpyramidlabels = isset($params['chartpyramidlabels']) ? $params['chartpyramidlabels'] : 'OnTop'; 
                $charttype = isset($params['charttype']) ? $params['charttype'] : '';
     		$chartbackgroundcolor = isset($params['chartbackgroundcolor']) ? $params['chartbackgroundcolor'] : '0x00000000';
     		$chartaltbackgroundcolor = isset($params['chartaltbackgroundcolor']) ? $params['chartaltbackgroundcolor'] : '0x00000000';
         	$charthgridcolor = isset($params['charthgridcolor']) ? $params['charthgridcolor'] : '0x00000000';
         	$chartvgridcolor = isset($params['chartvgridcolor']) ? $params['chartvgridcolor'] : '0x00000000';
         	$chartedgecolor = isset($params['chartedgecolor']) ? $params['chartedgecolor'] : '0x00000000';
         	$chartbordercolor = isset($params['chartbordercolor']) ? $params['chartbordercolor'] : '0x00000000';
            	$chartborder3d = isset($params['chartborder3d']) ? $params['chartborder3d'] : '0x00000000';
     		$chartborderrounding = isset($params['chartborderrounding']) ? $params['chartborderrounding'] : '0';
      		$chartborderextcolor = isset($params['chartborderextcolor']) ? $params['chartborderextcolor'] : '';
    		$chartborderthickness = isset($params['chartborderthickness']) ? $params['chartborderthickness'] : '0';
          	$chartframecolor = isset($params['chartframecolor']) ? $params['chartframecolor'] : '0x00000000';
     		$chartframeinnercolor = isset($params['chartframeinnercolor']) ? $params['chartframeinnercolor'] : '0x00000000';
     		$chartframeoutercolor = isset($params['chartframeoutercolor']) ? $params['chartframeoutercolor'] : '0x00000000';
     		$chartdropshadowcolor = isset($params['chartdropshadowcolor']) ? $params['chartdropshadowcolor'] : '0x00000000';
   		$chartdropshadowoffsetx = isset($params['chartdropshadowoffsetx']) ? $params['chartdropshadowoffsetx'] : '';
   		$chartdropshadowoffsety = isset($params['chartdropshadowoffsety']) ? $params['chartdropshadowoffsety'] : '';
		$chartdropshadowblurradius = isset($params['chartdropshadowblurradius']) ? $params['chartdropshadowblurradius'] : '';
       	  	$chartwallpaper = isset($params['chartwallpaper']) ? $params['chartwallpaper'] : '';
       		$chartbackgroundimg = isset($params['chartbackgroundimg']) ? $params['chartbackgroundimg'] : '';
    		$charttransparentcolor = isset($params['charttransparentcolor']) ? $params['charttransparentcolor'] : '0x00000000';
               	$charttitle = isset($params['charttitle']) ? $params['charttitle'] : '';
           	$charttitlefont = isset($params['charttitlefont']) ? $params['charttitlefont'] : '';
       		$charttitlefontsize = isset($params['charttitlefontsize']) ? $params['charttitlefontsize'] : '';
     		$charttitlefontcolor = isset($params['charttitlefontcolor']) ? $params['charttitlefontcolor'] : '0x000000';
        	$charttitlebgcolor = isset($params['charttitlebgcolor']) ? $params['charttitlebgcolor'] : '0x00000000';
	      	$charttitleedgecolor = isset($params['charttitleedgecolor']) ? $params['charttitleedgecolor'] : '0x00000000';
		$chartsubtitle = isset($params['chartsubtitle']) ? $params['chartsubtitle'] : '';
		$chartsubtitlefont = isset($params['chartsubtitlefont']) ? $params['chartsubtitlefont'] : '';
	    	$chartsubtitlefontsize = isset($params['chartsubtitlefontsize']) ? $params['chartsubtitlefontsize'] : '';
	   	$chartsubtitlefontcolor = isset($params['chartsubtitlefontcolor']) ? $params['chartsubtitlefontcolor'] : '0x000000';
	     	$chartsubtitlebgcolor = isset($params['chartsubtitlebgcolor']) ? $params['chartsubtitlebgcolor'] : '0x00000000';
	   	$chartsubtitleedgecolor = isset($params['chartsubtitleedgecolor']) ? $params['chartsubtitleedgecolor'] : '0x000000';
	   	$chartsubtitleposition = isset($params['chartsubtitleposition']) ? $params['chartsubtitleposition'] : 8;
		$chartlegendx = isset($params['chartlegendx']) ? $params['chartlegendx'] : '';
		$chartlegendy = isset($params['chartlegendy']) ? $params['chartlegendy'] : '';
		$chartlegendvert = isset($params['chartlegendvert']) ? $params['chartlegendvert'] : '';
		$chartlegendfont = isset($params['chartlegendfont']) ? $params['chartlegendfont'] : '';
	      	$chartlegendfontsize = isset($params['chartlegendfontsize']) ? $params['chartlegendfontsize'] : '';
	       	$chartlegendnumcols = isset($params['chartlegendnumcols']) ? $params['chartlegendnumcols'] : '';
		$chartaddtextx = isset($params['chartaddtextx']) ? $params['chartaddtextx'] : '';
		$chartaddtexty = isset($params['chartaddtexty']) ? $params['chartaddtexty'] : '';
		$chartaddtextfont = isset($params['chartaddtextfont']) ? $params['chartaddtextfont'] : '';
		$chartaddtexttext = isset($params['chartaddtexttext']) ? $params['chartaddtexttext'] : '';
	     	$chartaddtextfontsize = isset($params['chartaddtextfontsize']) ? $params['chartaddtextfontsize'] : '';
	    	$chartaddtextfontcolor = isset($params['chartaddtextfontcolor']) ? $params['chartaddtextfontcolor'] : '0x00000000';
	    	$chartaddtextalignment = isset($params['chartaddtextalignment']) ? $params['chartaddtextalignment'] : '';
		$chartaddtextangle = isset($params['chartaddtextangle']) ? $params['chartaddtextangle'] : '';
		$chartx = isset($params['chartx']) ? $params['chartx'] : '';
		$charty = isset($params['charty']) ? $params['charty'] : '';
		$chartdscolx = isset($params['chartdscolx']) ? $params['chartdscolx'] : '';
		$chartdscoly = isset($params['chartdscoly']) ? $params['chartdscoly'] : '';
		$chartdscolz = isset($params['chartdscolz']) ? $params['chartdscolz'] : '';
		$chartswapxy = isset($params['chartswapxy']) ? $params['chartswapxy'] : '';
		$chartxtitle = isset($params['chartxtitle']) ? $params['chartxtitle'] : '';
		$chartxtitlefont = isset($params['chartxtitlefont']) ? $params['chartxtitlefont'] : '';
		$chartxtitlefontsize = isset($params['chartxtitlefontsize']) ? $params['chartxtitlefontsize'] : '';
		$chartxtitlefontcolor = isset($params['chartxtitlefontcolor']) ? $params['chartxtitlefontcolor'] : '0x00000000';
		$chartytitle = isset($params['chartytitle']) ? $params['chartytitle'] : '';
		$chartytitlefont = isset($params['chartytitlefont']) ? $params['chartytitlefont'] : '';
		$chartytitlefontsize = isset($params['chartytitlefontsize']) ? $params['chartytitlefontsize'] : '';
		$chartytitlefontcolor = isset($params['chartytitlefontcolor']) ? $params['chartytitlefontcolor'] : '0x00000000';
		$chartaxiscolor = isset($params['chartaxiscolor']) ? $params['chartaxiscolor'] : '0x000000';
		$chartaxisfont = isset($params['chartaxisfont']) ? $params['chartaxisfont'] : '';
		$chartaxisfontcolor = isset($params['chartaxisfontcolor']) ? $params['chartaxisfontcolor'] : '0x000000';
		$chartaxisfontsize = isset($params['chartaxisfontsize']) ? $params['chartaxisfontsize'] : '';
		$chartaxisspacing = isset($params['chartaxisspacing']) ? $params['chartaxisspacing'] : 40;
		$chartaxisangle = isset($params['chartaxisangle']) ? $params['chartaxisangle'] : 90;
		$chartpyramidlayergap = isset($params['chartpyramidlayergap']) ? $params['chartpyramidlayergap'] : '0.00';
		$chartbarcolor_single = isset($params['chartbarcolor_single']) ? $params['chartbarcolor_single'] : '';
		$chartlinecolor_single = isset($params['chartlinecolor_single']) ? $params['chartlinecolor_single'] : '';
		$chartareacolor_single = isset($params['chartareacolor_single']) ? $params['chartareacolor_single'] : '';
		$chartbarcolor_multi = isset($params['chartbarcolor_multi']) ? $params['chartbarcolor_multi'] : '';
		$chartpyramidcolor_multi = isset($params['chartpyramidcolor_multi']) ? $params['chartpyramidcolor_multi'] : '';
		$chartlinecolor_multi = isset($params['chartlinecolor_multi']) ? $params['chartlinecolor_multi'] : '';
		$chartareacolor_multi = isset($params['chartareacolor_multi']) ? $params['chartareacolor_multi'] : '';
		$chartpiecolor_multi = isset($params['chartpiecolor_multi']) ? $params['chartpiecolor_multi'] : '';
		$chartbarroundedcorners = isset($params['chartbarroundedcorners']) ? $params['chartbarroundedcorners'] : '';
		$chartbarlabels = isset($params['chartbarlabels']) ? $params['chartbarlabels'] : '';
		$chartbareffect = isset($params['chartbareffect']) ? $params['chartbareffect'] : '';
		$chartpyramideffect = isset($params['chartpyramideffect']) ? $params['chartpyramideffect'] : '';
		$chartlineeffect = isset($params['chartlineeffect']) ? $params['chartlineeffect'] : '';
		$chartareaeffect = isset($params['chartareaeffect']) ? $params['chartareaeffect'] : '';
		$chartpieeffect = isset($params['chartpieeffect']) ? $params['chartpieeffect'] : '';
		$chartbargrouptype = isset($params['chartbargrouptype']) ? $params['chartbargrouptype'] : '';
		$chartareagrouptype = isset($params['chartareagrouptype']) ? $params['chartareagrouptype'] : '';
		$chartpiebreakoutslice = isset($params['chartpiebreakoutslice']) ? $params['chartpiebreakoutslice'] : -1;
		$chartgaugemajortick = isset($params['chartgaugemajortick']) ? $params['chartgaugemajortick'] : 50;
		$chartgaugeminortick = isset($params['chartgaugeminortick']) ? $params['chartgaugeminortick'] : 10;
		$chartgaugemicrotick = isset($params['chartgaugemicrotick']) ? $params['chartgaugemicrotick'] : 1;
		$chartgaugebordercolor = isset($params['chartgaugebordercolor']) ? $params['chartgaugebordercolor'] : '';
		$chartgaugebgcolor = isset($params['chartgaugebgcolor']) ? $params['chartgaugebgcolor'] : '0x00000000';
		$chartgaugeeffect = isset($params['chartgaugeeffect']) ? $params['chartgaugeeffect'] : '';
		$chartgaugefont = isset($params['chartgaugefont']) ? $params['chartgaugefont'] : '';
		$chartgaugefontsize = isset($params['chartgaugefontsize']) ? $params['chartgaugefontsize'] : '12';
		$chartgaugelabel = isset($params['chartgaugelabel']) ? $params['chartgaugelabel'] : '';
		$chartgaugelabelcolor = isset($params['chartgaugelabelcolor']) ? $params['chartgaugelabelcolor'] : '0x000000';
		$chartgaugebeginscale = isset($params['chartgaugebeginscale']) ? $params['chartgaugebeginscale'] : 0;
		$chartgaugeendscale = isset($params['chartgaugeendscale']) ? $params['chartgaugeendscale'] : 100;
		$chartgaugeradius = isset($params['chartgaugeradius']) ? $params['chartgaugeradius'] : 120;
		$chartmetertickinterval = isset($params['chartmetertickinterval']) ? $params['chartmetertickinterval'] : 100;
		$chartmeterbordercolor = isset($params['chartmeterbordercolor']) ? $params['chartmeterbordercolor'] : '';
                $chartmeterbgcolor = isset($params['chartmeterbgcolor']) ? $params['chartmeterbgcolor'] : '0x00000000';
                $chartmetereffect = isset($params['chartmetereffect']) ? $params['chartmetereffect'] : '';
                $chartmeterfont = isset($params['chartmeterfont']) ? $params['chartmeterfont'] : '';
                $chartmeterfontsize = isset($params['chartmeterfontsize']) ? $params['chartmeterfontsize'] : '12';
                $chartpyramidfont = isset($params['chartpyramidfont']) ? $params['chartpyramidfont'] : '';
                $chartpyramidfontcolor = isset($params['chartpyramidfontcolor']) ? $params['chartpyramidfontcolor'] : '0x000000';
                $chartpyramidfontsize = isset($params['chartpyramidfontsize']) ? $params['chartpyramidfontsize'] : '12';
                $chartmeterlabel = isset($params['chartmeterlabel']) ? $params['chartmeterlabel'] : '';
                $chartmeterlabelcolor = isset($params['chartmeterlabelcolor']) ? $params['chartmeterlabelcolor'] : '0x000000';
                $chartmeterbeginscale = isset($params['chartmeterbeginscale']) ? $params['chartmeterbeginscale'] : 0;
                $chartmeterendscale = isset($params['chartmeterendscale']) ? $params['chartmeterendscale'] : 100;
                $chartmetersize = isset($params['chartmetersize']) ? $params['chartmetersize'] : 250;
                $chartthreshold1_linecolor = isset($params['chartthreshold1_linecolor']) ? $params['chartthreshold1_linecolor'] : '0x00000000';
                $chartthreshold2_linecolor = isset($params['chartthreshold2_linecolor']) ? $params['chartthreshold2_linecolor'] : '0x00000000';
                $chartthreshold3_linecolor = isset($params['chartthreshold3_linecolor']) ? $params['chartthreshold3_linecolor'] : '0x00000000';
                $chartthreshold4_linecolor = isset($params['chartthreshold4_linecolor']) ? $params['chartthreshold4_linecolor'] : '0x00000000';
                $chartthreshold5_linecolor = isset($params['chartthreshold5_linecolor']) ? $params['chartthreshold5_linecolor'] : '0x00000000';
                $chartthreshold1_linewidth = isset($params['chartthreshold1_linewidth']) ? $params['chartthreshold1_linewidth'] : '0';
                $chartthreshold2_linewidth = isset($params['chartthreshold2_linewidth']) ? $params['chartthreshold2_linewidth'] : '0';
                $chartthreshold3_linewidth = isset($params['chartthreshold3_linewidth']) ? $params['chartthreshold3_linewidth'] : '0';
                $chartthreshold4_linewidth = isset($params['chartthreshold4_linewidth']) ? $params['chartthreshold4_linewidth'] : '0';
                $chartthreshold5_linewidth = isset($params['chartthreshold5_linewidth']) ? $params['chartthreshold5_linewidth'] : '0';
                $chartthreshold1_value = isset($params['chartthreshold1_value']) ? $params['chartthreshold1_value'] : '';
                $chartthreshold2_value = isset($params['chartthreshold2_value']) ? $params['chartthreshold2_value'] : '';
                $chartthreshold3_value = isset($params['chartthreshold3_value']) ? $params['chartthreshold3_value'] : '';
                $chartthreshold4_value = isset($params['chartthreshold4_value']) ? $params['chartthreshold4_value'] : '';
                $chartthreshold5_value = isset($params['chartthreshold5_value']) ? $params['chartthreshold5_value'] : '';
                $chartthreshold1_label = isset($params['chartthreshold1_label']) ? $params['chartthreshold1_label'] : '';
                $chartthreshold2_label = isset($params['chartthreshold2_label']) ? $params['chartthreshold2_label'] : '';
                $chartthreshold3_label = isset($params['chartthreshold3_label']) ? $params['chartthreshold3_label'] : '';
                $chartthreshold4_label = isset($params['chartthreshold4_label']) ? $params['chartthreshold4_label'] : '';
                $chartthreshold5_label = isset($params['chartthreshold5_label']) ? $params['chartthreshold5_label'] : '';
                $viewmenu = isset($params['viewmenu']) ? $params['viewmenu'] : '';

                $sql = "replace into viewobjects (`objname`, `objtype`, `objurl`, `setname`, `reststartproperty`,`objmarkup`, `gridcolumns`, `colformat`,`toolbarmenu`,`contextmenu`,`refreshrate`, `chartwidth`,`chartheight`,`charttype`,`chartbackgroundcolor`,`chartbordercolor`,`chartborder3d`,`chartborderrounding`,`chartborderextcolor`,`chartborderthickness`,`chartframecolor`,`chartframeinnercolor`,`chartframeoutercolor`,`chartdropshadowcolor`,`chartdropshadowoffsetx`,`chartdropshadowoffsety`,`chartdropshadowblurradius`,`chartwallpaper`,`chartbackgroundimg`,`charttransparentcolor`,`charttitle`,`charttitlefont`,`charttitlefontsize`,`charttitlefontcolor`,`charttitlebgcolor`,`charttitleedgecolor`,`chartsubtitle`,`chartsubtitlefont`,`chartsubtitlefontsize`,`chartsubtitlefontcolor`,`chartsubtitlebgcolor`,`chartsubtitleedgecolor`,`chartlegendx`,`chartlegendy`,`chartlegendvert`,`chartlegendfont`,`chartlegendfontsize`,`chartlegendnumcols`,`chartaddtextx`,`chartaddtexty`,`chartaddtextfont`,`chartaddtexttext`,`chartaddtextfontsize`,`chartaddtextfontcolor`,`chartaddtextalignment`,`chartaddtextangle`,`chartx`,`charty`,`chartswapxy`,`chartxtitle`,`chartytitle`,`chartdscolx`,`chartdscoly`,`chartdscolz`, `chartsubtitleposition`, `chartaltbackgroundcolor`, `charthgridcolor`, `chartvgridcolor`, `chartedgecolor`, `chartytitlefont`, `chartytitlefontsize`, `chartytitlefontcolor`, `chartaxiscolor`, `chartaxisfont`, `chartaxisfontcolor`, `chartaxisfontsize`, `chartaxisspacing`, `chartaxisangle`,`chartbarcolor_single`, `chartbarcolor_multi`, `chartbarroundedcorners`, `chartbarlabels`, `chartbareffect`, `chartxtitlefont`, `chartxtitlefontsize`, `chartxtitlefontcolor`, `chartbargrouptype`, `chartlinecolor_single`, `chartlinecolor_multi`,`chartlineeffect`, `chartareacolor_single`, `chartareacolor_multi`, `chartareaeffect`, `chartareagrouptype`, `chartpiecolor_multi`, `chartpiebreakoutslice`, `chartpieeffect`, `chartpieradius`, `chartpielabels`, `chartgaugemajortick`, `chartgaugeminortick`, `chartgaugemicrotick`, `chartgaugebordercolor`, `chartgaugebgcolor`, `chartgaugeeffect`, `chartgaugefont`, `chartgaugefontsize`, `chartgaugelabel`, `chartgaugelabelcolor`, `chartgaugebeginscale`, `chartgaugeendscale`, `chartgaugeradius`, `chartmeterbordercolor`, `chartmeterbgcolor`,`chartmetereffect`,`chartmeterfont`,`chartmeterfontsize`,`chartmeterlabel`,`chartmeterlabelcolor`,`chartmeterbeginscale`,`chartmeterendscale`,`chartmetersize`,`chartmetertickinterval`, `chartpyramidsize`, `chartpyramidlabels`,`chartpyramidlayergap`,`chartpyramidcolor_multi`,`chartpyramideffect`,`chartpyramidfont`,`chartpyramidfontcolor`,`chartpyramidfontsize`,`chartthreshold1_linewidth`,`chartthreshold1_linecolor`,`chartthreshold1_value`,`chartthreshold1_label`,`chartthreshold2_linewidth`,`chartthreshold2_linecolor`,`chartthreshold2_value`,`chartthreshold2_label`,`chartthreshold3_linewidth`,`chartthreshold3_linecolor`,`chartthreshold3_value`,`chartthreshold3_label`,`chartthreshold4_linewidth`,`chartthreshold4_linecolor`,`chartthreshold4_value`,`chartthreshold4_label`,`chartthreshold5_linewidth`,`chartthreshold5_linecolor`,`chartthreshold5_value`,`chartthreshold5_label`, `viewmenu`) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,? ,? ,? ,?, ?, ?, ?, ? ,? , ? ,? ,? ,? ,?, ?, ?, ?, ? ,?, ?, ? ,?, ?, ?, ?, ? ,?, ?, ?, ?, ?, ? ,? ,?, ?, ?, ?, ? ,?, ?, ? ,?, ?, ?, ?, ? ,?, ?, ?)";

                $stmt = $con->prepare($sql);
		
                $stmt->bind_param('ssssssssssiiissssisissssssssssssssssssssssssssssssssssssssssssssisssssssssssiisssssssssssssssssisisiiisssssssiiisssssssiiiiissssssisssssssssssssssssssss', $objname, $objtype, $objurl, $setname, $reststartproperty, $objmarkup, $gridcolumns, $colformat, $toolbarmenu, $contextmenu, $refreshrate, $chartwidth ,$chartheight ,$charttype ,$chartbackgroundcolor ,$chartbordercolor ,$chartborder3d ,$chartborderrounding ,$chartborderextcolor ,$chartborderthickness ,$chartframecolor ,$chartframeinnercolor ,$chartframeoutercolor ,$chartdropshadowcolor ,$chartdropshadowoffsetx ,$chartdropshadowoffsety ,$chartdropshadowblurradius ,$chartwallpaper ,$chartbackgroundimg ,$charttransparentcolor ,$charttitle ,$charttitlefont ,$charttitlefontsize ,$charttitlefontcolor ,$charttitlebgcolor ,$charttitleedgecolor ,$chartsubtitle ,$chartsubtitlefont ,$chartsubtitlefontsize ,$chartsubtitlefontcolor ,$chartsubtitlebgcolor ,$chartsubtitleedgecolor ,$chartlegendx ,$chartlegendy ,$chartlegendvert ,$chartlegendfont ,$chartlegendfontsize ,$chartlegendnumcols ,$chartaddtextx ,$chartaddtexty ,$chartaddtextfont ,$chartaddtexttext ,$chartaddtextfontsize ,$chartaddtextfontcolor ,$chartaddtextalignment ,$chartaddtextangle ,$chartx ,$charty ,$chartswapxy ,$chartxtitle ,$chartytitle, $chartdscolx,$chartdscoly,$chartdscolz, $chartsubtitleposition, $chartaltbackgroundcolor, $charthgridcolor, $chartvgridcolor, $chartedgecolor, $chartytitlefont, $chartytitlefontsize, $chartytitlefontcolor, $chartaxiscolor, $chartaxisfont, $chartaxisfontcolor, $chartaxisfontsize, $chartaxisspacing, $chartaxisangle, $chartbarcolor_single, $chartbarcolor_multi, $chartbarroundedcorners, $chartbarlabels, $chartbareffect, $chartxtitlefont, $chartxtitlefontsize, $chartxtitlefontcolor, $chartbargrouptype, $chartlinecolor_single, $chartlinecolor_multi, $chartlineeffect, $chartareacolor_single, $chartareacolor_multi, $chartareaeffect, $chartareagrouptype, $chartpiecolor_multi, $chartpiebreakoutslice, $chartpieeffect, $chartpieradius, $chartpielabels, $chartgaugemajortick, $chartgaugeminortick, $chartgaugemicrotick, $chartgaugebordercolor, $chartgaugebgcolor, $chartgaugeeffect, $chartgaugefont, $chartgaugefontsize, $chartgaugelabel, $chartgaugelabelcolor, $chartgaugebeginscale, $chartgaugeendscale, $chartgaugeradius, $chartmeterbordercolor, $chartmeterbgcolor, $chartmetereffect, $chartmeterfont, $chartmeterfontsize, $chartmeterlabel, $chartmeterlabelcolor, $chartmeterbeginscale, $chartmeterendscale, $chartmetersize, $chartmetertickinterval, $chartpyramidsize, $chartpyramidlabels, $chartpyramidlayergap, $chartpyramidcolor_multi, $chartpyramideffect, $chartpyramidfont, $chartpyramidfontcolor, $chartpyramidfontsize, $chartthreshold1_linewidth, $chartthreshold1_linecolor, $chartthreshold1_value, $chartthreshold1_label, $chartthreshold2_linewidth, $chartthreshold2_linecolor, $chartthreshold2_value, $chartthreshold2_label, $chartthreshold3_linewidth, $chartthreshold3_linecolor, $chartthreshold3_value, $chartthreshold3_label,$chartthreshold4_linewidth, $chartthreshold4_linecolor, $chartthreshold4_value, $chartthreshold4_label, $chartthreshold5_linewidth, $chartthreshold5_linecolor, $chartthreshold5_value, $chartthreshold5_label, $viewmenu);

                $stmt->execute();

		$params = array();
                $this->Read($params, $con);
        }

        private function Read($params, $con) {
                $sql = '';
                $objname = isset($params->objname) ? $params->objname : (isset($params['objname']) ? $params['objname'] : 'empty');

                if ($objname === 'empty') {
                $sql = "select * from viewobjects";
                } else {
                $sql = "select * from viewobjects where objname = '$objname'";
                }
                $response = $con->query($sql);
                $records = array();
                $rows = array();
                $recid = 1;

                while ($obj = $response->fetch_assoc())
                        {
                                $obj['recid'] = $recid;
                                $rows[] = $obj;
                                $recid = $recid + 1;
                        }

                $records['total'] = count($rows);
                $records['records'] = $rows;
                $jrows = json_encode($records);
                header('Content-Type: application/json');
                echo $jrows;

        }

        private function ReadContent($params, $con) {
                $sql = '';
                $objname = isset($params->objname) ? $params->objname : (isset($params['objname']) ? $params['objname'] : 'empty');

                if ($objname === 'empty') {
                $sql = "select * from viewobjects";
                } else {
                $sql = "select * from viewobjects where objname = '$objname'";
                }
                $response = $con->query($sql);
                $records = array();
                $rows = array();
		$griddata = array();
                $recid = 1;

                while ($obj = $response->fetch_assoc())
                        {
                                $obj['recid'] = $recid;
                                $rows[] = $obj;
                                $recid = $recid + 1;
                        }

                $records['total'] = count($rows);
                $records['records'] = $rows;

                $jrows = json_encode($records);
                header('Content-Type: application/json');
                echo $jrows;

        }

        private function Delete($params, $con)
        {

                $objname = $params[0]->objname ? $params[0]->objname : ($params[0]['objname'] ? $params[0]['objname'] : 'empty');
                if (strpos($objname, '(') !== false) {
                        $sql = "delete from viewobjects where objname in $objname";
                        $stmt = $con->prepare($sql);
                } else {
                        $sql = "delete from viewobjects where objname = ?";
                        $stmt = $con->prepare($sql);
                        $stmt->bind_param('s', $objname);
                }
                $stmt->execute();

		$params = array();
                $this->Read($params, $con);
        }
}


