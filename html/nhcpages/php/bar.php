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

# Grouping, if exists
$grouping = $chartinfo['z'];

# chartparams
$objname = $chartparams['objname'];
$objtype = $chartparams['objtype'];
$setname = $chartparams['setname'];
$reststartproperty = $chartparams['reststartproperty'];
$chartwidth = $chartparams['chartwidth'];
$chartheight = $chartparams['chartheight'];
$charttype = $chartparams['charttype'];
$chartbackgroundcolor = ctype_xdigit($chartparams['chartbackgroundcolor']) ? hexdec($chartparams['chartbackgroundcolor']) : 0xFF000000;
$chartaltbackgroundcolor = ctype_xdigit($chartparams['chartaltbackgroundcolor']) ? hexdec($chartparams['chartaltbackgroundcolor']) : 0xFF000000;
$charthgridcolor = ctype_xdigit($chartparams['charthgridcolor']) ? hexdec($chartparams['charthgridcolor']) : 0xFF000000;
$chartvgridcolor = ctype_xdigit($chartparams['chartvgridcolor']) ? hexdec($chartparams['chartvgridcolor']) : 0xFF000000;
$chartedgecolor = ctype_xdigit($chartparams['chartedgecolor']) ? hexdec($chartparams['chartedgecolor']) : 0xFF000000;
$chartbarroundedcorners = $chartparams['chartbarroundedcorners'];
$chartbarlabels = $chartparams['chartbarlabels'];
$chartbareffect = $chartparams['chartbareffect'];
$chartbarcolor_single = ctype_xdigit($chartparams['chartbarcolor_single']) ? hexdec($chartparams['chartbarcolor_single']) : 0x6699bb;
$chartbarcolor_multi = $chartparams['chartbarcolor_multi'];
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
$chartaxiscolor = ctype_xdigit($chartparams['chartaxiscolor']) ? hexdec($chartparams['chartaxiscolor']) : 0xFF0000;
$chartaxisfont = $chartparams['chartaxisfont'];
$chartaxisfontcolor = ctype_xdigit($chartparams['chartaxisfontcolor']) ? hexdec($chartparams['chartaxisfontcolor']) : 0xFF0000;
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
$chartbargrouptype = $chartparams['chartbargrouptype'];
$chartthreshold1_value = $chartparams['chartthreshold1_value'];
$chartthreshold1_linecolor = ctype_xdigit($chartparams['chartthreshold1_linecolor']) ? hexdec($chartparams['chartthreshold1_linecolor']) : 0xFF000000;
$chartthreshold1_linewidth = $chartparams['chartthreshold1_linewidth'];
$chartthreshold1_label = $chartparams['chartthreshold1_label'];
$chartthreshold2_value = $chartparams['chartthreshold2_value'];
$chartthreshold2_linecolor = ctype_xdigit($chartparams['chartthreshold2_linecolor']) ? hexdec($chartparams['chartthreshold2_linecolor']) : 0xFF000000;
$chartthreshold2_linewidth = $chartparams['chartthreshold2_linewidth'];
$chartthreshold2_label = $chartparams['chartthreshold2_label'];
$chartthreshold3_value = $chartparams['chartthreshold3_value'];
$chartthreshold3_linecolor = ctype_xdigit($chartparams['chartthreshold3_linecolor']) ? hexdec($chartparams['chartthreshold3_linecolor']) : 0xFF000000;;
$chartthreshold3_linewidth = $chartparams['chartthreshold3_linewidth'];
$chartthreshold3_label = $chartparams['chartthreshold3_label'];
$chartthreshold4_value = $chartparams['chartthreshold4_value'];
$chartthreshold4_linecolor = ctype_xdigit($chartparams['chartthreshold4_linecolor']) ? hexdec($chartparams['chartthreshold4_linecolor']) : 0xFF000000;;
$chartthreshold4_linewidth = $chartparams['chartthreshold4_linewidth'];
$chartthreshold4_label = $chartparams['chartthreshold4_label'];
$chartthreshold5_value = $chartparams['chartthreshold5_value'];
$chartthreshold5_linecolor = ctype_xdigit($chartparams['chartthreshold5_linecolor']) ? hexdec($chartparams['chartthreshold5_linecolor']) : 0xFF000000;;
$chartthreshold5_linewidth = $chartparams['chartthreshold5_linewidth'];
$chartthreshold5_label = $chartparams['chartthreshold5_label'];

$multi = 0;
$multidata = new \stdClass;
$dedup_labels = array();

if (count($grouping) > 0) {
	$multi = 1;
	$x = 0;
	foreach ($labels as $label) {
		$multidata->{$label}->{$grouping[$x]} = $data[$x];
		$x++;
	}

	foreach ($multidata as $key=>$values) {
		$dedup_labels[] = $key;
	}
	$labels = $dedup_labels;
}


# Create a XYChart
$c = new XYChart($chartwidth, $chartheight, 0xeeeeff, 0x000000, 1);
$c->setRoundedFrame();

# set sizing and positioning based on chart width and height
$charttitlefontsize = $s->GetSizePos('charttitlefontsize',$chartheight, $chartwidth,'bar');
$chartsubtitlefontsize = $s->GetSizePos('chartsubtitlefontsize',$chartheight, $chartwidth,'bar');
$chartytitlefontsize = $s->GetSizePos('chartytitlefontsize',$chartheight, $chartwidth,'bar');
$chartxtitlefontsize = $s->GetSizePos('chartxtitlefontsize',$chartheight, $chartwidth,'bar');
$plotwidth = $s->GetSizePos('plotwidth',$chartheight, $chartwidth,'bar');
$plotheight = $s->GetSizePos('plotheight',$chartheight, $chartwidth,'bar');
$chartx = $s->GetSizePos('chartx',$chartheight,$chartwidth,'bar');
$charty = $s->GetSizePos('charty',$chartheight,$chartwidth,'bar');
$chartaxisfontsize = $s->GetSizePos('chartaxisfontsize',$chartheight,$chartwidth,'bar');


# Add a title box 
$c->addTitle($charttitle, $charttitlefont, $charttitlefontsize, $charttitlefontcolor, $charttitlebgcolor, $charttitleedgecolor);

# Add subtitle
$c->addTitle2($chartsubtitleposition, $chartsubtitle, $chartsubtitlefont, $chartsubtitlefontsize, $chartsubtitlefontcolor, $chartsubtitlebgcolor, $chartsubtitleedgecolor);

# Set the plotarea, size, background and border
# and light grey (0xcccccc) horizontal grid lines
$c->setPlotArea($chartx, $charty, $plotwidth, $plotheight, $chartbackgroundcolor, $chartaltbackgroundcolor, $chartedgecolor, $charthgridcolor, $chartvgridcolor);

# Set the x and y axis stems to transparent and the label font to 12pt Arial
$c->xAxis->setColors($chartaxiscolor);
$c->yAxis->setColors($chartaxiscolor);
$c->xAxis->setLabelStyle($chartaxisfont, $chartaxisfontsize, $chartaxisfontcolor, $chartaxisangle);
$c->yAxis->setLabelStyle($chartaxisfont, $chartaxisfontsize, $chartaxisfontcolor, $chartaxisangle);

# Add data, bar colors and border color
if (strlen($chartbarcolor_multi) > 0) {
	$colors = explode(',', $chartbarcolor_multi);
	$barcolors = array();

	foreach ($colors as $color) {
		$barcolors[] =  hexdec($color);
	}

	//Check for multi-bar
	if ($multi === 1) {

		if ($chartbargrouptype == 'MultiBar') {
		$barLayerObj = $c->addBarLayer2(Side,3);
		}
		else if ($chartbargrouptype == 'Stacked') {
		$barLayerObj = $c->addBarLayer2(Stack);
		}
		else if ($chartbargrouptype == 'Percent') {
		$barLayerObj = $c->addBarLayer2(Percentage);
		} else {
		$barLayerObj = $c->addBarLayer2(Side, 3);
		}

		$x=0;
		$mdata = array();
		$grouplabels = array();
		$records = new stdClass();
		foreach ($multidata as $key=>$value) {
			foreach ($value as $k=>$v) {
				$records->{$k}->mdata[] = $v;
			}
		}		

		$y = 0;
		foreach ($records as $k=>$v) {
			$color = $barcolors[$y];
			$barLayerObj->addDataSet($records->{$k}->mdata, $color, $k);
			$y++;
		}
		

	} else {

	$barLayerObj = $c->addBarLayer3($data, $barcolors);

	}

} else {
	$barLayerObj = $c->addBarLayer($data, $chartbarcolor_single);
}

if ($chartbareffect == 'Glass') {
	$barLayerObj->setBorderColor(Transparent, glassEffect(NormalGlare, Left));
} else if ($chartbareffect == 'Soft') {
	$barLayerObj->setBorderColor(Transparent, softLighting(Left));
} else if ($chartbareffect == 'Gradient') {
	$barLayerObj->setBorderColor(Transparent, barLighting(0.75, 2.0));
} else if ($chartbareffect == '2DCylinder') {
	$barLayerObj->setBarShape(CircleShape);
} else if ($chartbareffect == '3DBar') {
	$barLayerObj->set3D();
} else if ($chartbareffect == '3DCylinder') {
	$barLayerObj->set3D(10);
	$barLayerObj->setBarShape(CircleShape);
} else if ($chartbareffect == '3DBarSoft') {
	$barLayerObj->set3D();
	$barLayerObj->setBorderColor(Transparent, softLighting(Top));
} else {
	$barLayerObj->setBorderColor(Transparent);
}


# set rounding
if ($chartbarroundedcorners == 'true') {
	$barLayerObj->setRoundedCorners();
}

# set bar labels
if ($chartbarlabels == 'true') {
	$barLayerObj->setAggregateLabelStyle("Arial", $chartaxisfontsize * .8);
}

# Set the labels on the x axis.
$c->xAxis->setLabels($labels);

# For the automatic y-axis labels, set the minimum spacing to 40 pixels.
$c->yAxis->setTickDensity($chartaxisspacing);

# Add a title to the y axis using dark grey (0x555555) 14pt Arial Bold font
$c->yAxis->setTitle($chartytitle, $chartytitlefont, $chartytitlefontsize, $chartytitlefontcolor);
$c->xAxis->setTitle($chartxtitle, $chartxtitlefont, $chartxtitlefontsize, $chartxtitlefontcolor);

$legendObj = $c->addLegend(50, 25, false, "arialbd.ttf", 10);
$legendObj->setBackground(Transparent);

# Add Thresholds

$thresh1 = $c->yAxis->addMark($chartthreshold1_value, $chartthreshold1_linecolor, "$chartthreshold1_label");
$thresh1->setLineWidth($chartthreshold1_linewidth);

$thresh2 = $c->yAxis->addMark($chartthreshold2_value, $chartthreshold2_linecolor, "$chartthreshold2_label");
$thresh2->setLineWidth($chartthreshold2_linewidth);

$thresh3 = $c->yAxis->addMark($chartthreshold3_value, $chartthreshold3_linecolor, "$chartthreshold3_label");
$thresh3->setLineWidth($chartthreshold3_linewidth);

$thresh4 = $c->yAxis->addMark($chartthreshold4_value, $chartthreshold4_linecolor, "$chartthreshold4_label");
$thresh4->setLineWidth($chartthreshold4_linewidth);

$thresh5 = $c->yAxis->addMark($chartthreshold5_value, $chartthreshold5_linecolor, "$chartthreshold5_label");
$thresh5->setLineWidth($chartthreshold5_linewidth);


# Output the chart
header("Content-type: image/png");
print($c->makeChart2(PNG));
?>
