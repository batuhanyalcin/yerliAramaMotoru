<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title></title>
</head>
<body>
	<?php
function crawl_page($url, $depth = 2,$usturl){
    static $GidilenURLLER = array();

	if (isset($GidilenURLLER[$url]) || isset($GidilenURLLER[$usturl.$url]) || $depth === 0) {
		return;
	}
	$GidilenURLLER[$url] = true;
	$GidilenURLLER[$usturl.$url] = true;

    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile($url);

    $anchors = $dom->getElementsByTagName('a');
    foreach ($anchors as $element) {
        $href = $element->getAttribute('href');
		if(strstr($href,"http") || strstr($href,"#"))
			continue;
		//echo $href."<br />";
		echo $url.$href."<br />";
		crawl_page($url.$href,$depth-1,$url);
	}
}
crawl_page("https://www.btk.gov.tr", 2);
	?>
</body>
</html>