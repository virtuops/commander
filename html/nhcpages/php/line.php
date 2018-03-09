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


# The data for the chart
$data = $chartinfo['y'];

# The labels for the chart
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
$chartaltbackgroundcolor = ctype_xdigit($chartparams['chartaltbackgroundcolor']) ? hexdec($chartparams['chartaltbackgroundcolor']) : -1;
$charthgridcolor = ctype_xdigit($chartparams['charthgridcolor']) ? hexdec($chartparams['charthgridcolor']) : 0xFF000000;
$chartvgridcolor = ctype_xdigit($chartparams['chartvgridcolor']) ? hexdec($chartparams['chartvgridcolor']) : 0xFF000000;
$chartedgecolor = ctype_xdigit($chartparams['chartedgecolor']) ? hexdec($chartparams['chartedgecolor']) : 0xFF000000;
$chartlineeffect = $chartparams['chartlineeffect'];
$chartlinecolor_single = ctype_xdigit($chartparams['chartlinecolor_single']) ? hexdec($chartparams['chartlinecolor_single']) : 0x6699bb;
$chartlinecolor_multi = $chartparams['chartlinecolor_multi'];
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

# Set Size and Pos
$charttitlefontsize = $s->GetSizePos('charttitlefontsize',$chartheight, $chartwidth,'line');
$chartsubtitlefontsize = $s->GetSizePos('chartsubtitlefontsize',$chartheight, $chartwidth,'line');
$chartytitlefontsize = $s->GetSizePos('chartytitlefontsize',$chartheight, $chartwidth,'line');
$chartxtitlefontsize = $s->GetSizePos('chartxtitlefontsize',$chartheight, $chartwidth,'line');
$plotwidth = $s->GetSizePos('plotwidth',$chartheight, $chartwidth,'line');
$plotheight = $s->GetSizePos('plotheight',$chartheight, $chartwidth,'line');
$chartx = $s->GetSizePos('chartx',$chartheight,$chartwidth,'line');
$charty = $s->GetSizePos('charty',$chartheight,$chartwidth,'line');
$chartaxisfontsize = $s->GetSizePos('chartaxisfontsize',$chartheight,$chartwidth,'line');

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

# Add a title box 
$c->addTitle($charttitle, $charttitlefont, $charttitlefontsize, $charttitlefontcolor, $charttitlebgcolor, $charttitleedgecolor);

# Add subtitle
$c->addTitle2($chartsubtitleposition,$chartsubtitle, $chartsubtitlefont, $chartsubtitlefontsize, $chartsubtitlefontcolor, $chartsubtitlebgcolor, $chartsubtitleedgecolor);

# Set the plotarea, size, background and border
$c->setPlotArea($chartx, $charty, $plotwidth, $plotheight, $chartbackgroundcolor, $chartaltbackgroundcolor, $chartedgecolor, $charthgridcolor, $chartvgridcolor);

# Set the x and y axis 
$c->xAxis->setColors($chartaxiscolor);
$c->yAxis->setColors($chartaxiscolor);
$c->xAxis->setLabelStyle($chartaxisfont, $chartaxisfontsize, $chartaxisfontcolor, $chartaxisangle);
$c->yAxis->setLabelStyle($chartaxisfont, $chartaxisfontsize, $chartaxisfontcolor, $chartaxisangle);

# Add data, bar colors and border color
if ($multi==1 || strlen($chartlinecolor_multi) > 0) {

	$colors = explode(',', $chartlinecolor_multi);
	$linecolors = array();

	foreach ($colors as $color) {
		$linecolors[] = hexdec($color);
	}

	//Check for multi-bar
	if ($multi === 1) {
		if ($chartlineeffect == 'Spline') {
		$lineLayerObj = $c->addSplineLayer();
		} else if ($chartlineeffect == 'StepLine') {
		$lineLayerObj = $c->addStepLineLayer();
		} else {
		$lineLayerObj = $c->addLineLayer2();
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
		$color = isset($linecolors[$y]) ? $linecolors[$y] : 0x6699bb;
		$lineLayerObj->addDataSet($records->{$k}->mdata, $color, $k);
		$y++;
		}
		

	} else {

		if ($chartlineeffect == 'Spline') {
                $lineLayerObj = $c->addSplineLayer($data, $linecolors);
                } else if ($chartlineeffect == 'StepLine') {
                $lineLayerObj = $c->addStepLineLayer($data, $linecolors);
                } else {
		$lineLayerObj = $c->addLineLayer3($data, $linecolors);
		}

	}

} else {

	if ($chartlineeffect == 'Spline') {
        $lineLayerObj = $c->addSplineLayer($data, $chartlinecolor_single);
        } else if ($chartlineeffect == 'StepLine') {
        $lineLayerObj = $c->addStepLineLayer($data, $chartlinecolor_single);
        } else {
	$lineLayerObj = $c->addLineLayer($data, $chartlinecolor_single);
	}

}

if ($chartlineeffect == '3DLine') {
	$lineLayerObj->set3D();
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
