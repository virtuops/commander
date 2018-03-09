<?php
require_once("../../../libs/ChartDirector/lib/phpchartdir.php");
require_once("../../../app/server/utils/DataCrud.php");
require_once("../../../app/server/utils/Log.php");
require_once("sizepos.php");

$c = new DataCrud();
$l = new Log();
$s = new SizePos();

$settings = parse_ini_file('../../../app/server/config.ini');
$params = array();
$params['host'] = $settings['dbhost'];
$params['username'] = $settings['dbuser'];
$params['password'] = $settings['dbpass'];
$params['database'] = $settings['dbname'];
$params['port'] = $settings['dbport'];

$params['charttype'] = $_GET['charttype'];
$params['objname'] = $_GET['objname'];

$chartparams = $c->CrudOperation('getparams','chartdata',$params,'null');
$chartinfo = $c->CrudOperation('getchartdata','chartdata',$chartparams,'null');



# The data for the bar chart
$data = $chartinfo['y'];

# The labels for the bar chart
$labels = $chartinfo['x'];

# chartparams
$objname = $chartparams['objname'];
$objtype = $chartparams['objtype'];
$setname = $chartparams['setname'];
$reststartproperty = $chartparams['reststartproperty'];
$chartwidth = $chartparams['chartwidth'];
$chartheight = $chartparams['chartheight'];
$charttype = $chartparams['charttype'];
$chartbackgroundcolor = ctype_xdigit($chartparams['chartbackgroundcolor']) ? hexdec($chartparams['chartbackgroundcolor']) : 0xFF000000;
$chartaltbackgroundcolor = ctype_xdigit($chartparams['chartaltbackgroundcolor']) ? hexdec($chartparams['chartaltbackgroundcolor']) : -1;
$charthgridcolor = ctype_xdigit($chartparams['charthgridcolor']) ? hexdec($chartparams['charthgridcolor']) : 0xFF000000;
$chartvgridcolor = ctype_xdigit($chartparams['chartvgridcolor']) ? hexdec($chartparams['chartvgridcolor']) : 0xFF000000;
$chartedgecolor = ctype_xdigit($chartparams['chartedgecolor']) ? hexdec($chartparams['chartedgecolor']) : 0xFF000000;
$chartbarroundedcorners = $chartparams['chartbarroundedcorners'];
$chartbarlabels = $chartparams['chartbarlabels'];
$chartpielabels = $chartparams['chartpielabels'];
$chartpyramidlabels = $chartparams['chartpyramidlabels'];
$chartpyramidlayergap = $chartparams['chartpyramidlayergap'];
$chartpyramidfont = $chartparams['chartpyramidfont'];
$chartpyramidfontsize = $chartparams['chartpyramidfontsize'];
$chartbareffect = $chartparams['chartbareffect'];
$chartpyramideffect = $chartparams['chartpyramideffect'];
$chartpieradius = $chartparams['chartpieradius'];
$chartpyramidsize = $chartparams['chartpyramidsize'];
$chartpiebreakoutslice = $chartparams['chartpiebreakoutslice'];
$chartlineeffect = $chartparams['chartlineeffect'];
$chartareaeffect = $chartparams['chartareaeffect'];
$chartpyramidfontcolor = ctype_xdigit($chartparams['chartpyramidfontcolor']) ? hexdec($chartparams['chartpyramidfontcolor']) : 0x6699bb;
$chartbarcolor_single = ctype_xdigit($chartparams['chartbarcolor_single']) ? hexdec($chartparams['chartbarcolor_single']) : 0x6699bb;
$chartlinecolor_single = ctype_xdigit($chartparams['chartlinecolor_single']) ? hexdec($chartparams['chartlinecolor_single']) : 0x6699bb;
$chartareacolor_single = ctype_xdigit($chartparams['chartareacolor_single']) ? hexdec($chartparams['chartareacolor_single']) : 0x6699bb;
$chartbarcolor_multi = $chartparams['chartbarcolor_multi'];
$chartlinecolor_multi = $chartparams['chartlinecolor_multi'];
$chartareacolor_multi = $chartparams['chartareacolor_multi'];
$chartpiecolor_multi = $chartparams['chartpiecolor_multi'];
$chartpyramidcolor_multi = $chartparams['chartpyramidcolor_multi'];
$chartgaugemajortick = $chartparams['chartgaugemajortick'];
$chartgaugeminortick = $chartparams['chartgaugeminortick'];
$chartgaugemicrotick = $chartparams['chartgaugemicrotick'];
$chartgaugeeffect = $chartparams['chartgaugeeffect'];
$chartmetertickinterval = $chartparams['chartmetertickinterval'];
$chartmetereffect = $chartparams['chartmetereffect'];
$chartgaugefont = $chartparams['chartgaugefont'];
$chartmeterfont = $chartparams['chartmeterfont'];
$chartgaugefontsize = $chartparams['chartgaugefontsize'];
$chartmeterfontsize = $chartparams['chartmeterfontsize'];
$chartgaugelabel = $chartparams['chartgaugelabel'];
$chartmeterlabel = $chartparams['chartmeterlabel'];
$chartgaugebeginscale = $chartparams['chartgaugebeginscale'];
$chartmeterbeginscale = $chartparams['chartmeterbeginscale'];
$chartgaugeendscale = $chartparams['chartgaugeendscale'];
$chartmeterendscale = $chartparams['chartmeterendscale'];
$chartgaugeradius = $chartparams['chartgaugeradius'];
$chartmetersize = $chartparams['chartmetersize'];
$chartgaugelabelcolor = ctype_xdigit($chartparams['chartgaugelabelcolor']) ? hexdec($chartparams['chartgaugelabelcolor']) : 0xFF000000;
$chartmeterlabelcolor = ctype_xdigit($chartparams['chartmeterlabelcolor']) ? hexdec($chartparams['chartmeterlabelcolor']) : 0xFF000000;
$chartgaugebordercolor = ctype_xdigit($chartparams['chartgaugebordercolor']) ? hexdec($chartparams['chartgaugebordercolor']) : 0xFF000000;
$chartmeterbordercolor = ctype_xdigit($chartparams['chartmeterbordercolor']) ? hexdec($chartparams['chartmeterbordercolor']) : 0xFF000000;
$chartgaugebgcolor = ctype_xdigit($chartparams['chartgaugebgcolor']) ? hexdec($chartparams['chartgaugebgcolor']) : 0xFF000000;
$chartmeterbgcolor = ctype_xdigit($chartparams['chartmeterbgcolor']) ? hexdec($chartparams['chartmeterbgcolor']) : 0xFF000000;
$chartbordercolor = ctype_xdigit($chartparams['chartbordercolor']) ? hexdec($chartparams['chartbordercolor']) : 0xFF000000;
$chartborder3d = $chartparams['chartborder3d'];
$chartborderrounding = $chartparams['chartborderrounding'];
$chartborderextcolor = $chartparams['chartborderextcolor'];
$chartborderthickness = $chartparams['chartborderthickness'];
$chartframecolor = $chartparams['chartframecolor'];
$chartframeinnercolor = $chartparams['chartframeinnercolor'];
$chartframeoutercolor = $chartparams['chartframeoutercolor'];
$chartdropshadowcolor = $chartparams['chartdropshadowcolor'];
$chartdropshadowoffsetx = $chartparams['chartdropshadowoffsetx'];
$chartdropshadowoffsety = $chartparams['chartdropshadowoffsety'];
$chartdropshadowblurradius = $chartparams['chartdropshadowblurradius'];
$chartwallpaper = $chartparams['chartwallpaper'];
$chartbackgroundimg = $chartparams['chartbackgroundimg'];
$charttransparentcolor = $chartparams['charttransparentcolor'];
$charttitle = $chartparams['charttitle'];
$charttitlefont = $chartparams['charttitlefont'];
$charttitlefontsize = $chartparams['charttitlefontsize'];
$charttitlefontcolor = ctype_xdigit($chartparams['charttitlefontcolor']) ? hexdec($chartparams['charttitlefontcolor']) : 0xFF000000;
$charttitlebgcolor = ctype_xdigit($chartparams['charttitlebgcolor']) ? hexdec($chartparams['charttitlebgcolor']) : 0xFF000000;
$charttitleedgecolor = ctype_xdigit($chartparams['charttitleedgecolor']) ? hexdec($chartparams['charttitleedgecolor']) : 0xFF000000;
$chartsubtitle = $chartparams['chartsubtitle'];
$chartsubtitlefont = $chartparams['chartsubtitlefont'];
$chartsubtitlefontsize = $chartparams['chartsubtitlefontsize'];
$chartsubtitlefontcolor = ctype_xdigit($chartparams['chartsubtitlefontcolor']) ? hexdec($chartparams['chartsubtitlefontcolor']) : 0xFF000000;
$chartsubtitlebgcolor = ctype_xdigit($chartparams['chartsubtitlebgcolor']) ? hexdec($chartparams['chartsubtitlebgcolor']) : 0xFF000000;
$chartsubtitleedgecolor = ctype_xdigit($chartparams['chartsubtitleedgecolor']) ? hexdec($chartparams['chartsubtitleedgecolor']) : 0xFF000000;
$chartsubtitleposition = $chartparams['chartsubtitleposition'];
$chartytitle = $chartparams['chartytitle'];
$chartytitlefont = $chartparams['chartytitlefont'];
$chartytitlefontsize = $chartparams['chartytitlefontsize'];
$chartytitlefontcolor = ctype_xdigit($chartparams['chartytitlefontcolor']) ? hexdec($chartparams['chartytitlefontcolor']) : 0xFF000000;
$chartaxiscolor = $chartparams['chartaxiscolor'];
$chartaxisfont = $chartparams['chartaxisfont'];
$chartaxisfontcolor = ctype_xdigit($chartparams['chartaxisfontcolor']) ? hexdec($chartparams['chartaxisfontcolor']) : 0x000000;
$chartaxisfontsize = $chartparams['chartaxisfontsize'];
$chartaxisspacing = $chartparams['chartaxisspacing'];
$chartaxisangle = $chartparams['chartaxisangle'];
$chartlegendx = $chartparams['chartlegendx'];
$chartlegendy = $chartparams['chartlegendy'];
$chartlegendvert = $chartparams['chartlegendvert'];
$chartlegendfont = $chartparams['chartlegendfont'];
$chartlegendfontsize = $chartparams['chartlegendfontsize'];
$chartlegendnumcols = $chartparams['chartlegendnumcols'];
$chartaddtextx = $chartparams['chartaddtextx'];
$chartaddtexty = $chartparams['chartaddtexty'];
$chartaddtextfont = $chartparams['chartaddtextfont'];
$chartaddtexttext = $chartparams['chartaddtexttext'];
$chartaddtextfontsize = $chartparams['chartaddtextfontsize'];
$chartaddtextfontcolor = $chartparams['chartaddtextfontcolor'];
$chartaddtextalignment = $chartparams['chartaddtextalignment'];
$chartaddtextangle = $chartparams['chartaddtextangle'];
$chartx = $chartparams['chartx'];
$charty = $chartparams['charty'];
$chartdscolx = $chartparams['chartdscolx'];
$chartdscoly = $chartparams['chartdscoly'];
$chartdscolz = $chartparams['chartdscolz'];
$chartxtitle = $chartparams['chartxtitle'];
$chartxtitlefont = $chartparams['chartxtitlefont'];
$chartxtitlefontsize = $chartparams['chartxtitlefontsize'];
$chartxtitlefontcolor = ctype_xdigit($chartparams['chartxtitlefontcolor']) ? hexdec($chartparams['chartxtitlefontcolor']) : 0xFF000000;
$chartswapxy = $chartparams['chartswapxy'];
$chartbargrouptype = $chartparams['chartbargrouptype'];
$chartareagrouptype = $chartparams['chartareagrouptype'];

$colors = explode(',', $chartpyramidcolor_multi);
$pyramidcolors = array();

while (count($colors) < count($data)) {
        foreach ($colors as $color) {
                array_push($colors, $color);
        }
}


foreach ($colors as $color) {
        $pyramidcolors[] = hexdec($color);
}


# set sizing and positioning based on chart width and height
$charttitlefontsize = $s->GetSizePos('charttitlefontsize',$chartheight, $chartwidth,'pyramid');
$chartsubtitlefontsize = $s->GetSizePos('chartsubtitlefontsize',$chartheight, $chartwidth,'pyramid');
$chartytitlefontsize = $s->GetSizePos('chartytitlefontsize',$chartheight, $chartwidth,'pyramid');
$chartxtitlefontsize = $s->GetSizePos('chartxtitlefontsize',$chartheight, $chartwidth,'pyramid');
$chartx = $s->GetSizePos('chartpyramidx',$chartheight,$chartwidth,'pyramid');
$charty = $s->GetSizePos('chartpyramidy',$chartheight,$chartwidth,'pyramid');
$chartpyramidwidth = $s->GetSizePos('chartpyramidwidth',$chartheight,$chartwidth,'pyramid');
$chartpyramidheight = $s->GetSizePos('chartpyramidheight',$chartheight,$chartwidth,'pyramid');
$chartpyramidfontsize = $s->GetSizePos('chartpyramidfontsize',$chartheight,$chartwidth,'pyramid');


# Create a PyramidChart object 

if ($chartpyramidlabels == 'Side') {
$chartwidth = $chartwidth * 2;
$chartheight = $chartheight * 1.25;
$chartx = $chartx * 1.55;
$charty = $charty * 1.35;
	if ($chartpyramideffect == 'Funnel') {
	$charty = $charty * .85;
	}
}


$c = new PyramidChart($chartwidth, $chartheight);

if ($chartpyramideffect == '3D Pyramid') {
	$c->setPyramidSize($chartx, $charty, $chartpyramidwidth, $chartpyramidheight); 
	$c->setViewAngle(15);	
}
else if ($chartpyramideffect == 'Cone') {
	
	$c->setConeSize($chartx, $charty, $chartpyramidwidth, $chartpyramidheight);
	$c->setViewAngle(15);
}
else if ($chartpyramideffect == 'Funnel') {
	$c->setFunnelSize($chartx, $charty, $chartpyramidwidth, $chartpyramidheight);
	$c->setViewAngle(5);
} else {

	$c->setPyramidSize($chartx, $charty, $chartpyramidwidth, $chartpyramidheight); 
}

# Set Gap
$c->setLayerGap($chartpyramidlayergap);

# Add a title box
$c->addTitle($charttitle, $charttitlefont, $charttitlefontsize, $charttitlefontcolor, $charttitlebgcolor, $charttitleedgecolor);

# Add subtitle
$c->addTitle2($chartsubtitleposition,$chartsubtitle, $chartsubtitlefont, $chartsubtitlefontsize, $chartsubtitlefontcolor, $chartsubtitlebgcolor, $chartsubtitleedgecolor);


if ($chartpyramidlabels == 'OnTop') {
$c->setCenterLabel("{label}\n{value}", $chartpyramidfont, $chartpyramidfontsize, $chartpyramidfontcolor);
} else if ($chartpyramidlabels == 'Side') {
$c->setRightLabel("{label}\n{value}", $chartpyramidfont, $chartpyramidfontsize, $chartpyramidfontcolor);
}


# Set the pyramid data and the pyramid labels
$c->setData($data, $labels);

if (count($pyramidcolors) > 0) {
$c->setColors2(DataColor, $pyramidcolors);
}

# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));

?>
