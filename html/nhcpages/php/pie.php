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

$objname = $chartparams['objname'];
$objtype = $chartparams['objtype'];
$setname = $chartparams['setname'];
$reststartproperty = $chartparams['reststartproperty'];
$chartwidth = $chartparams['chartwidth'];
$chartheight = $chartparams['chartheight'];
$charttype = $chartparams['charttype'];
$chartbackgroundcolor = ctype_xdigit($chartparams['chartbackgroundcolor']) ? hexdec($chartparams['chartbackgroundcolor']) : 0xFF000000;
$chartaltbackgroundcolor = ctype_xdigit($chartparams['chartaltbackgroundcolor']) ? hexdec($chartparams['chartaltbackgroundcolor']) : -1;
$chartedgecolor = ctype_xdigit($chartparams['chartedgecolor']) ? hexdec($chartparams['chartedgecolor']) : 0xFF000000;
$chartpielabels = $chartparams['chartpielabels'];
$chartpieradius = $chartparams['chartpieradius'];
$chartpiebreakoutslice = $chartparams['chartpiebreakoutslice'];
$chartpiecolor_multi = $chartparams['chartpiecolor_multi'];
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
$chartpieeffect = $chartparams['chartpieeffect'];
$chartdscolx = $chartparams['chartdscolx'];
$chartdscoly = $chartparams['chartdscoly'];
$chartdscolz = $chartparams['chartdscolz'];
$chartxtitle = $chartparams['chartxtitle'];
$chartxtitlefont = $chartparams['chartxtitlefont'];
$chartxtitlefontsize = $chartparams['chartxtitlefontsize'];
$chartxtitlefontcolor = ctype_xdigit($chartparams['chartxtitlefontcolor']) ? hexdec($chartparams['chartxtitlefontcolor']) : 0xFF000000;

# set sizing and positioning based on chart width and height
$charttitlefontsize = $s->GetSizePos('charttitlefontsize',$chartheight, $chartwidth,'pie');
$chartsubtitlefontsize = $s->GetSizePos('chartsubtitlefontsize',$chartheight, $chartwidth,'pie');
$chartytitlefontsize = $s->GetSizePos('chartytitlefontsize',$chartheight, $chartwidth,'pie');
$chartxtitlefontsize = $s->GetSizePos('chartxtitlefontsize',$chartheight, $chartwidth,'pie');
$plotwidth = $s->GetSizePos('plotwidth',$chartheight, $chartwidth,'pie');
$plotheight = $s->GetSizePos('plotheight',$chartheight, $chartwidth,'pie');
$chartx = $s->GetSizePos('chartx',$chartheight,$chartwidth,'pie');
$charty = $s->GetSizePos('charty',$chartheight,$chartwidth,'pie');
$chartpieradius = $s->GetSizePos('chartpieradius',$chartheight,$chartwidth,'pie');


$colors = explode(',', $chartpiecolor_multi);
$piecolors = array();

while (count($colors) < count($data)) {
	foreach ($colors as $color) {
		array_push($colors, $color);
	}
}

foreach ($colors as $color) {
        $piecolors[] = hexdec($color);
}


# Create a PieChart object of size 360 x 300 pixels
$c = new PieChart($chartwidth, $chartheight);


if ($chartpieeffect == 'Donut' || $chartpieeffect == 'Donut Gradient' || $chartpieeffect == '3D Donut' || $chartpieeffect == '3D Donut Gradient') {
	$c->setDonutSize($chartx, $charty, $chartpieradius, $chartpieradius/2);

	if ($chartpieeffect == 'Donut Gradient') {
	$c->setSectorStyle(RingShading);
	}
	if ($chartpieeffect == '3D Donut') {
	$c->set3D(25);
        }
	if ($chartpieeffect == '3D Donut Gradient') {
	$c->set3D(25);
	$c->setSectorStyle(LocalGradientShading);
        }
} else {
	$c->setPieSize($chartx, $charty, $chartpieradius);
}

# Add a title box
$c->addTitle($charttitle, $charttitlefont, $charttitlefontsize, $charttitlefontcolor, $charttitlebgcolor, $charttitleedgecolor);

# Add subtitle
$c->addTitle2($chartsubtitleposition,$chartsubtitle, $chartsubtitlefont, $chartsubtitlefontsize, $chartsubtitlefontcolor, $chartsubtitlebgcolor, $chartsubtitleedgecolor);

if ($chartpielabels == 'OnTop') {
$c->setLabelPos(-40);
} else if ($chartpielabels == 'WithColors') {
$c->setLabelLayout(SideLayout);
$t = $c->setLabelStyle();
$t->setBackground(SameAsMainColor, Transparent, glassEffect());
$t->setRoundedCorners(5);
}



# Set the pie data and the pie labels
$c->setData($data, $labels);

if (count($piecolors) > 0) {
$c->setColors2(DataColor, $piecolors);
}


if ($chartpieeffect == '3D') {
	$c->set3D();
}
if ($chartpieeffect == 'Gradient') {
	$c->setSectorStyle(LocalGradientShading, 0xbb000000, 1);
}
if ($chartpieeffect == '3D Gradient') {
        $c->setSectorStyle(LocalGradientShading, 0xbb000000, 1);
	$c->set3D();
}

if ($chartpiebreakoutslice > -1) {
	$c->setExplode($chartpiebreakoutslice);
}


# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));

?>
