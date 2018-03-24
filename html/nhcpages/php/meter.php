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
$chartmetertickinterval = $chartparams['chartmetertickinterval'];
$chartmetereffect = $chartparams['chartmetereffect'];
$chartmeterfont = $chartparams['chartmeterfont'];
$chartmeterfontsize = $chartparams['chartmeterfontsize'];
$chartmeterlabel = $chartparams['chartmeterlabel'];
$chartmeterbeginscale = $chartparams['chartmeterbeginscale'];
$chartmeterendscale = $chartparams['chartmeterendscale'];
$chartmetersize = $chartparams['chartmetersize'];
$chartmeterlabelcolor = ctype_xdigit($chartparams['chartmeterlabelcolor']) ? hexdec($chartparams['chartmeterlabelcolor']) : 0xFF000000;
$chartmeterbordercolor = ctype_xdigit($chartparams['chartmeterbordercolor']) ? hexdec($chartparams['chartmeterbordercolor']) : 0xFF000000;
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


# Set size and positions
$chartx = $s->GetSizePos('chartx',$chartheight,$chartwidth,'meter');
$charty = $s->GetSizePos('charty',$chartheight,$chartwidth,'meter');
$horizx = $s->GetSizePos('chartmeterhorizx',$chartheight,$chartwidth,'meter');
$horizy = $s->GetSizePos('chartmeterhorizy',$chartheight,$chartwidth,'meter');
$horizwidth = $s->GetSizePos('chartmeterhorizwidth',$chartheight,$chartwidth,'meter');
$horizheight = $s->GetSizePos('chartmeterhorizheight',$chartheight,$chartwidth,'meter');
$vertx = $s->GetSizePos('chartmetervertx',$chartheight,$chartwidth,'meter');
$vertxbarscale = $s->GetSizePos('chartmetervertxbarscale',$chartheight,$chartwidth,'meter');
$verty = $s->GetSizePos('chartmeterverty',$chartheight,$chartwidth,'meter');
$vertwidth = $s->GetSizePos('chartmetervertwidth',$chartheight,$chartwidth,'meter');
$vertheight = $s->GetSizePos('chartmetervertheight',$chartheight,$chartwidth,'meter');
$chartylabel = $s->GetSizePos('chartylabel',$chartheight,$chartwidth,'meter');
$chartybox = $s->GetSizePos('chartybox',$chartheight,$chartwidth,'meter');
$chartxbox = $s->GetSizePos('chartxbox',$chartheight,$chartwidth,'meter');

# Create a LinearMeter object
if ($chartmetereffect == 'Horizontal') {
$m = new LinearMeter($chartwidth, $chartheight, $chartmeterbgcolor, $chartmeterbordercolor);
$m->setRoundedFrame(Transparent);
$m->setThickFrame(3);
$m->setMeter($horizx, $horizy, $horizwidth, $horizheight, Top);
$smoothColorScale = array(0, 0X00bbbb, $chartmeterendscale * .25, 0x6666ff, $chartmeterendscale * .5, 0x00ff00, $chartmeterendscale * .75, 0xffff00, $chartmeterendscale, 0xff0000);
$m->addColorScale($smoothColorScale);
$m->addPointer($value, 0x0000cc);
$m->setColor(TextColor,$chartmeterlabelcolor);
$m->addText(10, $chartheight * .85, $chartmeterlabel, $chartmeterfont, $chartmeterfontsize, TextColor, Left);
$t = $m->addText($chartwidth * .95, $chartheight * .85, $m->formatValue($value, "2"), "arialbd.ttf", 8, 0xffffff, Right);
$t->setBackground(0x000000, 0x000000, -1);
$t->setRoundedCorners(3);
}
if ($chartmetereffect == 'Vertical') {
$m = new LinearMeter($chartwidth, $chartheight, $chartmeterbgcolor, $chartmeterbordercolor);
$m->setRoundedFrame(Transparent);
$m->setThickFrame(3);
$m->setMeter($vertx, $verty, $vertwidth, $vertheight);
$smoothColorScale = array(0, 0X00bbbb, $chartmeterendscale * .25, 0x6666ff, $chartmeterendscale * .5, 0x00ff00, $chartmeterendscale * .75, 0xffff00, $chartmeterendscale, 0xff0000);
$m->addColorScale($smoothColorScale);
$m->addPointer($value, 0x0000cc);
$textBoxObj = $m->addTitle($chartmeterlabel, $chartmeterfont, $chartmeterfontsize, $chartmeterlabelcolor);
$textBoxObj->setBackground($chartmeterbordercolor);
$textBoxObj = $m->addTitle2(Bottom, $m->formatValue($value, "2"), "arialbd.ttf", 8, $chartmeterlabelcolor);
$textBoxObj->setBackground($chartmeterbordercolor);
}
if ($chartmetereffect == 'Horiz. Bar') {
$m = new LinearMeter($chartwidth, $chartheight, $chartmeterbgcolor, $chartmeterbordercolor);
$m->setRoundedFrame(Transparent);
$m->setThickFrame(3);
$m->setMeter($horizx, $horizy, $horizwidth, $horizheight, Top);
$smoothColorScale = array(0, 0X00bbbb, $chartmeterendscale * .25, 0x6666ff, $chartmeterendscale * .5, 0x00ff00, $chartmeterendscale * .75, 0xffff00, $chartmeterendscale, 0xff0000);
$m->addColorScale($smoothColorScale, $chartheight * .6, 8);
$m->setColor(TextColor,$chartmeterlabelcolor);
$m->addText(10, $chartheight * .85, $chartmeterlabel, $chartmeterfont, $chartmeterfontsize, TextColor, Left);
$t = $m->addText($chartwidth * .95, $chartheight * .85, $m->formatValue($value, "2"), "arialbd.ttf", 8, 0xffffff, Right);
$t->setBackground(0x000000, 0x000000, -1);
$t->setRoundedCorners(3);
$m->addBar(0, $value, 0x0088ff, glassEffect(NormalGlare, Top), 4);
}
if ($chartmetereffect == 'Vert. Bar') {
$m = new LinearMeter($chartwidth, $chartheight, $chartmeterbgcolor, $chartmeterbordercolor);
$m->setRoundedFrame(Transparent);
$m->setThickFrame(3);
$m->setMeter($vertx, $verty, $vertwidth, $vertheight);
$smoothColorScale = array(0, 0x0000ff, 25, 0x0088ff, 50, 0x00ff00, 75, 0xffff00, 100, 0xff0000);
$m->addColorScale($smoothColorScale, $vertxbarscale, 8);
$textBoxObj = $m->addTitle($chartmeterlabel, $chartmeterfont, $chartmeterfontsize, $chartmeterlabelcolor);
$textBoxObj->setBackground($chartmeterbordercolor);
$textBoxObj = $m->addTitle2(Bottom, $m->formatValue($value, "2"), "arialbd.ttf", 8, $chartmeterlabelcolor);
$textBoxObj->setBackground($chartmeterbordercolor);
$m->addBar(0, $value, 0x0088ff, glassEffect(NormalGlare, Top), 4);
}

$m->setScale($chartmeterbeginscale, $chartmeterendscale, $chartmetertickinterval);


# Output the chart
header("Content-type: image/png");
print($m->makeChart2(PNG));
?>
