<?php
session_start();
function TurkcedenIngilizce($Keyword){
	$from_arr=array("ç", "Ç", "ğ", "Ğ", "ı", "İ", "ö", "Ö", "ü", "Ü", "ş", "Ş");
	$to_arr=array("c", "C", "ğ", "Ğ", "i", "I", "o", "O", "u", "U", "s", "S");
	return str_replace($from_arr, $to_arr, $Keyword);
}
?>