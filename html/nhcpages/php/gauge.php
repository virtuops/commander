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


# The labels for the chart
$value = $chartinfo['x'][0];

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
$chartedgecolor = ctype_xdigit($chartparams['chartedgecolor']) ? hexdec($chartparams['chartedgecolor']) : 0xFF000000;
$chartgaugemajortick = $chartparams['chartgaugemajortick'];
$chartgaugeminortick = $chartparams['chartgaugeminortick'];
$chartgaugemicrotick = $chartparams['chartgaugemicrotick'];
$chartgaugeeffect = $chartparams['chartgaugeeffect'];
$chartgaugefont = $chartparams['chartgaugefont'];
$chartgaugefontsize = $chartparams['chartgaugefontsize'];
$chartgaugelabel = $chartparams['chartgaugelabel'];
$chartgaugebeginscale = $chartparams['chartgaugebeginscale'];
$chartgaugeendscale = $chartparams['chartgaugeendscale'];
$chartgaugeradius = $chartparams['chartgaugeradius'];
$chartgaugelabelcolor = ctype_xdigit($chartparams['chartgaugelabelcolor']) ? hexdec($chartparams['chartgaugelabelcolor']) : 0xFF000000;
$chartgaugebordercolor = ctype_xdigit($chartparams['chartgaugebordercolor']) ? hexdec($chartparams['chartgaugebordercolor']) : 0xFF000000;
$chartgaugebgcolor = ctype_xdigit($chartparams['chartgaugebgcolor']) ? hexdec($chartparams['chartgaugebgcolor']) : 0xFF000000;
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

# Set size and positions
$charttitlefontsize = $s->GetSizePos('charttitlefontsize',$chartheight, $chartwidth,'gauge');
$chartsubtitlefontsize = $s->GetSizePos('chartsubtitlefontsize',$chartheight, $chartwidth,'gauge');
$chartgaugefontsize = $s->GetSizePos('chartgaugefontsize',$chartheight, $chartwidth,'gauge');
$chartx = $s->GetSizePos('chartx',$chartheight,$chartwidth,'gauge');
$charty = $s->GetSizePos('charty',$chartheight,$chartwidth,'gauge');
$chartgaugeradius = $s->GetSizePos('chartgaugeradius',$chartheight,$chartwidth,'gauge');
$chartgaugescalebackground = $s->GetSizePos('chartgaugescalebackground',$chartheight,$chartwidth,'gauge');

$textlocation = Center;
if ($chartgaugeeffect == 'SemiCircle') {
$m = new AngularMeter($chartwidth, $chartheight, $chartgaugebgcolor, $chartgaugebordercolor);
$m->setMeter($chartx, $charty, $chartgaugeradius, -90, 90);
$m->addScaleBackground($chartgaugescalebackground, $chartgaugebgcolor, 3, $chartgaugebordercolor);
$textlocation = Center;
} 
if ($chartgaugeeffect == 'Circle') {
$chartgaugeradius = $chartgaugeradius * .7;
$m = new AngularMeter($chartwidth, $chartheight, $chartgaugebgcolor, $chartgaugebordercolor);
$m->setMeter($chartx, $charty * .675, $chartgaugeradius, -145, 145);
$m->addRing(0, $chartgaugeradius * 1.09, $chartgaugebgcolor);
$m->addRing( $chartgaugeradius * 1.06,  $chartgaugeradius * 1.09, $chartgaugebordercolor);
$textlocation = Center;
} 
if ($chartgaugeeffect == 'Rectangle') {
$m = new AngularMeter($chartwidth, $chartheight, $chartgaugebgcolor, $chartgaugebordercolor);
$m->setMeter($chartx, $charty, $chartgaugeradius, -60, 60);
$m->setRoundedFrame(Transparent);
$m->setThickFrame(4);
$textlocation = BottomCenter;
} 


$m->setScale($chartgaugebeginscale, $chartgaugeendscale, $chartgaugemajortick, $chartgaugeminortick, $chartgaugemicrotick);

# Set the scale label style 
# pixels pointing inwards, and their widths to 2/1/1 pixels.
$m->setLabelStyle($chartgaugefont, $chartgaugefontsize);
$m->setTickLength(-16, -16, -10);
$m->setLineWidth(0, 2, 1, 1);

# Add a smooth color scale to the meter
$smoothColorScale = array($chartgaugebeginscale, 0x3333ff, $chartgaugeendscale * .25, 0x0088ff, $chartgaugeendscale * .50, 0x00ff00, $chartgaugeendscale * .75, 0xdddd00, $chartgaugeendscale, 0xff0000);
$m->addColorScale($smoothColorScale);

# Add a text label 
$m->setColor(TextColor, $chartgaugelabelcolor);
$m->addText($chartx, $charty - ($charty * .17), $chartgaugelabel, $chartgaugefont, $chartgaugefontsize, TextColor, $textlocation);

# Add a red (0xff0000) pointer at the specified value
$m->addPointer2($value, 0xff0000);


# Output the chart
header("Content-type: image/png");
print($m->makeChart2(PNG));

?>
