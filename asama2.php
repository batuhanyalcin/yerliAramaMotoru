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
	<div align="center"><!-- div for body  -->
	<?php
	
	$uppercase = false;
if(isset($_POST['urlkumesi'])){
	
	
	if(isset($_POST['uppercase']))
		if($_POST['uppercase'] == "on")
			$uppercase = true;
	
	$ArananNew = TurkcedenIngilizce($_POST['aranan']);
	if(!$uppercase)
		$ArananNew = mb_strtolower($ArananNew);
	
	$ArananNew = str_replace(",","%%SON%%",$ArananNew);
	$ArananNew = str_replace(" ","%%SON%%",$ArananNew);
	$ArananNew = str_replace(";","%%SON%%",$ArananNew);
	$ArananNew = explode("%%SON%%",$ArananNew);
	
	
	//Siteleri Getir
	$urller = explode("\n",str_replace("\r","",$_POST['urlkumesi']));
	$Siteler = array();
	$SiteNameFixed = array();
	foreach($urller as $url){
		/*echo $url."<br />";
		echo "<br />";
		echo "<br />";
		echo "<br />";
		echo "<br />";*/
		$GetWebSite = file_get_contents($url);
		$GetWebSite = html_entity_decode($GetWebSite, ENT_COMPAT | ENT_HTML401, 'UTF-8');
		$GetWebSite = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', "", $GetWebSite);
		$GetWebSite = preg_replace('/<style\b[^>]*>(.*?)<\/style>/is', "", $GetWebSite);
		$GetWebSite = strip_tags($GetWebSite);
		$GetWebSite = TurkcedenIngilizce($GetWebSite);
		$UrlFixed = TurkcedenIngilizce($url);
		if(!$uppercase){
			$UrlFixed = mb_strtolower($UrlFixed);
			$GetWebSite = mb_strtolower($GetWebSite);
		}
		$Siteler[$url] = $GetWebSite;
		$SiteNameFixed[$url] = $UrlFixed;
	}
	
	
	$ArananlarArray = array();
	$ArananlarArray2 = array();
	foreach($ArananNew as $arananlar){
		if(strlen($arananlar) <= 0) continue;
		//echo $arananlar."<br />";
		foreach($Siteler as $site => $val){
			if(!isset($ArananlarArray[$site]))
				$ArananlarArray[$site] = array();
			if(!isset($ArananlarArray2[$site]))
				$ArananlarArray2[$site] = array();
			$SiteFix = $SiteNameFixed[$site];
			//$ArananlarArray[$site][] = array(substr_count($val,$arananlar),substr_count($SiteFix,$arananlar));
			$ArananlarArray[$site][] = substr_count($val,$arananlar);
			$ArananlarArray2[$site][] = substr_count($SiteFix,$arananlar);
		}
		
	}
	//echo "<br />";
	//print_r($ArananlarArray);
	$SitePuanlar = array();
	$index = 0;
	foreach($ArananlarArray as $Site => $rakamlar){
		//$rakamlar = $Data[0];
		$Urldekisimler = $ArananlarArray2[$Site][$index];
		//print_r($Urldekisimler);
		/*echo "<br />";
		echo "<br />";
		echo "<br />";
		echo "<br />";
		echo sizeof($rakamlar)."<br />";*/
		$SitePuanlar[$Site] = 0;
		for($i = 0;$i<sizeof($rakamlar);$i++){
			$SitePuanlar[$Site] += $rakamlar[$i];
			$SitePuanlar[$Site] += $Urldekisimler[$i]*5;
		}
		//echo "<br />";
		for($i = 0;$i<sizeof($rakamlar)-1;$i++){
			$SitePuanlar[$Site] -= abs($rakamlar[$i]-$rakamlar[$i+1]);
		}
		$index++;
	}
	arsort($SitePuanlar);
	//print_r($SitePuanlar);
	
	
	
	
	
	//echo strip_tags($GetWebSite);
	//echo $GetWebSite."<br />";
	
	//echo $_POST['aranan']." sayfada <b>".."</b> tane var.";
	
}



?>


	<form action="" method="post">
	<input type="text" name="aranan" placeholder="Aranacak keyword" value="<?php if(isset($_POST['aranan'])) echo $_POST['aranan']; ?>" /> 
	<textarea name="urlkumesi" id="" cols="30" rows="10" placeholder="URL Kümelerini sırasıyla entera basarak giriniz"><?php if(isset($_POST['urlkumesi'])) echo $_POST['urlkumesi']; ?></textarea>
	<input type="checkbox" <?php if($uppercase) echo "checked"; ?> name="uppercase" /> Küçük büyük dikkat edem mi ? <br />
	<input type="submit" value="Kaç tane var say" />
	</form>
	<div><b>Sonuçlar</b></div>
	<?php
		foreach($SitePuanlar as $siteler => $puan){
			echo $siteler.'=>'.$puan.'<br />';
		}
	
	?>

	<br /><br /><br />
	<p> <a href="home.php">Home  </a> <a href="asama1.php">Asama 1  </a> <a href="asama3.php">Asama 3</a> </p>
</div>
</body>
</html>
<?php
require_once("footer.php");
?>