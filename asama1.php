<?php
require_once("header.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="tr">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
	<title>Arama motoru</title>
	<meta charset="UTF-8">
</head>
<body>
	<meta charset="UTF-8">
	<form action="" method="post">
	<input type="text" name="aranan" placeholder="Aranacak keyword" /> 
	<input type="text" name="url" placeholder="Aranacak site" /> <br />
	<input type="checkbox" name="uppercase" /> Küçük büyük dikkat edem mi ? <br />
	<input type="submit" value="Kaç tane var SAY" />
	</form>
	<?php
	
if(isset($_POST['url'])){
	$GetWebSite = file_get_contents($_POST['url']);
	$GetWebSite = html_entity_decode($GetWebSite, ENT_COMPAT | ENT_HTML401, 'UTF-8');
	$uppercase = false;
	if(isset($_POST['uppercase']))
		if($_POST['uppercase'] == "on")
			$uppercase = true;
	$GetWebSite = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $GetWebSite);
	$GetWebSite = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $GetWebSite);
	$GetWebSite = strip_tags($GetWebSite);
	$GetWebSite = TurkcedenIngilizce($GetWebSite);
	$ArananNew = TurkcedenIngilizce($_POST['aranan']);
	if(!$uppercase){
		$GetWebSite = mb_strtolower($GetWebSite);
		$ArananNew = mb_strtolower($ArananNew);
	}
	echo "GetWebSite : ".$GetWebSite."<br />";
	echo "ArananNew : ".$ArananNew."<br />";
	echo $_POST['aranan']." sayfada <b>".substr_count($GetWebSite,$ArananNew)."</b> tane var.";
	
}



	?>
</body>
</html>
<?php
require_once("footer.php");
?>