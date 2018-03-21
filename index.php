<?php
include("security.php");

?>
<!DOCTYPE html>
<html>
<head>
    <title>VirtuOps&trade; Commander</title>
    <script src="libs/jquery/jquery-3.1.1.min.js" type="text/javascript"></script>
    <script src="libs/w2ui/w2ui-1.5.rc1.min.js" type="text/javascript"></script>
    <script src="libs/visjs/vis.min.js" type="text/javascript"></script>
    <script src="libs/justgage/raphael-2.1.4.min.js" type="text/javascript"></script>
    <script src="libs/justgage/justgage.js" type="text/javascript"></script>
    <script src="libs/chartist/chartist.min.js" type="text/javascript"></script>
    <script src="libs/jquery/jquery-ui.min.js" type="text/javascript"></script>
    <script src="libs/jquery/jquery.panzoom-master/dist/jquery.panzoom.min.js" type="text/javascript"></script>
    <script src="libs/jquery/jquery-mousewheel-master/jquery.mousewheel.min.js" type="text/javascript"></script>
    <script src="libs/jquery/jquery.flowchart.js" type="text/javascript"></script>
    <script data-main="libs/main" src="libs/require/require.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="libs/css/mkadvantage.css" />
    <link rel="stylesheet" type="text/css" href="libs/css/login.css" />
    <link rel="stylesheet" type="text/css" href="libs/css/jquery.flowchart.css">
    <link rel="stylesheet" type="text/css" href="libs/css/custom.css" />
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<div id="layout" style="width: 100%; position: fixed; padding:0; margin:0; top:0; left:0; width: 100%; height: 100%;"></div>

<div id="connectionform" style="width: 750px; visibility: hidden">
</div>


<div id="datasetform" style="width: 750px; visibility: hidden">
</div>

<div id="toolform" style="width: 750px; visibility: hidden">
</div>

<div id="menuform" style="width: 750px; visibility: hidden">
</div>

<div id="viewform" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_iframe" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_html" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_bar" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_area" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_pie" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_gauge" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_meter" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_pyramid" style="width: 750px; visibility: hidden">
</div>

<div id="viewobjectform_line" style="width: 750px; visibility: hidden">
</div>

<div id="groupbottomform" style="width: 750px; visibility: hidden;">
</div>


<script type="text/javascript">


 $(function(){
      $("#groupbottomform").load("html/groupbottomform.html");
      $("#connectionform").load("html/connectionform.html");
      $("#datasetform").load("html/datasetform.html");
      $("#toolform").load("html/toolform.html");
      $("#menuform").load("html/menuform.html");
      $("#viewform").load("html/viewform.html");
      $("#viewobjectform").load("html/viewobjectform.html");
      $("#viewobjectform_iframe").load("html/viewobjectform_iframe.html");
      $("#viewobjectform_bar").load("html/viewobjectform_bar.html");
      $("#viewobjectform_area").load("html/viewobjectform_area.html");
      $("#viewobjectform_line").load("html/viewobjectform_line.html");
      $("#viewobjectform_pie").load("html/viewobjectform_pie.html");
      $("#viewobjectform_gauge").load("html/viewobjectform_gauge.html");
      $("#viewobjectform_meter").load("html/viewobjectform_meter.html");
      $("#viewobjectform_pyramid").load("html/viewobjectform_pyramid.html");
      $("#viewobjectform_html").load("html/viewobjectform_html.html");
    });

</script>
</body>
</html>

