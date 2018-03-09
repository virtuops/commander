<?php

require_once __DIR__.'/../../../app/server/utils/Log.php';

Class SizePos {

        private $l;
	private $value;

        public function __construct()
        {
                $this->l = new Log();
        }

        public function GetSizePos($component, $height=300, $width=400, $type){
	
	if (strlen($type) == 0) {
		$this->l->varErrorLog('Need a chart type.');
		return;
	} else {
	$this->value = $this->$component($height, $width, $type);
	return $this->value;
	}

	}

	private function charttitlefontsize ($height, $width, $type) {
	$val = floor(($height * .1) / 3) < 26 ? floor(($height * .1) / 3)  : 26;
	return $val;
	}

	private function chartsubtitlefontsize ($height, $width, $type) {
	$val = floor(($height * .075) / 3) < 14 ? floor(($height * .1) / 3)  : 14;
	return $val;
	}

	private function chartxtitlefontsize ($height, $width, $type) {
	$val = floor(($height * .1) / 3) < 14 ? floor(($height * .1) / 3)  : 14;
	return $val;
	}

	private function chartytitlefontsize ($height, $width, $type) {
	$val = floor(($height * .1) / 3) < 14 ? floor(($height * .1) / 3)  : 14;
	return $val;
	}

	private function chartgaugefontsize ($height, $width, $type) {
	$val = floor(($height * .1) / 3) < 50 && floor(($height * .1) / 3) > 10? floor(($height * .1) / 3)  : 10;
	return $val;
	}

	private function chartpyramidfontsize ($height, $width, $type) {
	$val = floor(($height * .1) / 3) < 50 && floor(($height * .1) / 3) > 10? floor(($height * .1) / 3)  : 10;
	return $val;
	}

	private function chartaxisfontsize ($height, $width, $type) {
	$val = floor(($height * .1) / 3) < 10 ? floor(($height * .1) / 3)  : 10;
	return $val;
	}

	private function chartx ($height, $width, $type) {
		if ($type == 'pie') {
		$val = ceil($width * .5444444);
		return $val;
		} else if ($type == 'gauge') {
		$val = ceil($width * .5);
		return $val;
		} else {
		$val = ceil($width * .1444444);
		return $val;
		}
	}

	private function charty ($height, $width, $type) {
		if ($type == 'bar') {	
		$val = floor($height * .1833333);
		return $val;
		} else if ($type == 'pie') {
		$val = floor($height * .453333);
		return $val;
		} else if ($type == 'gauge') {
		$val = floor($height * .735666);
		return $val;
		} else if ($type == 'line') {
		$val = floor($height * .1533333);
		return $val;
		} else {
		$val = floor($height * .1533333);
		return $val;
		}
	}

	private function plotwidth ($height, $width, $type) {
		if ($type == 'bar') {
		$val = floor($width * .75);
		return $val;
		} else if ($type == 'line') {
		$val = floor($width * .75);
		return $val;
		} else {
		$val = floor($width * .75);
		return $val;

		}
	}

	private function chartpyramidwidth ($height, $width, $type) {
		$val = floor($width * .5);
		return $val;
	}

	private function plotheight ($height, $width, $type) {
		if ($type == 'bar') {
		$val = floor($height * .6);
		return $val;
		} else if ($type == 'line') {
		$val = floor($height * .6);
		return $val;
		} else {
		$val = floor($height * .6);
		return $val;

		}
	}

	private function chartpyramidheight ($height, $width, $type) {
		$val = floor($height * .75);
		return $val;
	}

	private function chartpyramidx ($height, $width, $type) {
		$val = floor($width * .5);
		return $val;
	}

	private function chartpyramidy ($height, $width, $type) {
		$val = floor($height * .5);
		return $val;
	}

	private function chartpieradius ($height, $width, $type) {
		$val = floor($height * .3);
		return $val;
	}

	private function chartgaugeradius ($height, $width, $type) {
		$val = floor($height * .6);
		return $val;
	}

	private function chartgaugescalebackground ($height, $width, $type) {
		$val = floor($height * .656);
		return $val;
	}

	private function chartmeterhorizwidth ($height, $width, $type) {
	$val = $width * .9;
	return $val;
	}

	private function chartmeterhorizx ($height, $width, $type) {
	$val = $width * .05;
	return $val;
	}

	private function chartmeterhorizheight ($height, $width, $type) {
	$val = $height * .25;
	return $val;
	}

	private function chartmeterhorizy ($height, $width, $type) {
	$val = $height * .25;
	return $val;
	}

        private function chartmetervertwidth ($height, $width, $type) {
        $val = $width * .25;
        return $val;
        }

        private function chartmetervertx ($height, $width, $type) {
        $val = $width * .37;
        return $val;
        }

        private function chartmetervertxbarscale ($height, $width, $type) {
        $val = $width * .65;
        return $val;
        }

        private function chartmetervertheight ($height, $width, $type) {
		if ($height <= 550) {
		$val = $height * .80;
		return $val;
		} else if ($height >=550 && $height < 700) {
		$val = $height * .90;
		return $val;
		} else {
		$val = $height * .90;
		return $val;
		}
        }

        private function chartmeterverty ($height, $width, $type) {
		if ($height <= 550) {
		$val = $height * .1;
		return $val;
		} else if ($height >=550 && $height < 700) {
		$val = $height * .05;
		return $val;
		} else {
		$val = $height * .05;
		return $val;
		}
        }

	private function chartylabel ($height, $width, $type) {
	$val = $width * .9;
	return $val;
	}

	private function chartybox ($height, $width, $type) {
	$val = $width * .9;
	return $val;
	}

	private function chartxbox ($height, $width, $type) {
	$val = $height * .9;
	return $val;
	}

}
?>
