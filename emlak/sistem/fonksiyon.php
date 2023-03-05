<?php 
	define("URL","http://localhost/emlak/");

	function guvenlik($deger){
		$deger = trim($deger);
		$deger = addslashes($deger);
		$deger = strip_tags($deger);
		return $deger;
		
	}
	
	function uyeGirisKontrol(){
		if($_SESSION["giris"] != md5(sha1(md5("oke"))))
		{
			header("Location:http://localhost/emlak/giris");
		}
		
	}
	function isimDuzelt($deger) 
	{
		$turkce = array("ş","Ş","ı","(",")","'","ü","Ü","ö","Ö","ç","Ç"," ","/","*","?","ş","Ş","ı","ğ","Ğ","İ","ö","Ö","Ç","ç","ü","Ü","!");
		$duzgun = array("s","S","i","","","","u","U","o","O","c","C","-","-","-","","s","S","i","g","G","I","o","O","C","c","u","U","");
		$deger = str_replace($turkce,$duzgun,$deger);
		$deger = rand(1,10000)."_".$deger; //aynı isimle dosya olmasın diye rastgele sayı üretildi.
		return $deger;
	}
	function etiketTemizleme($deger)
	{
		$deger = str_replace("<","#1;",$deger);
		$deger = str_replace(">","#2;",$deger);
		return $deger;
	}
	function etkiketYazdir($deger)
	{
		$deger = str_replace("#1;","<",$deger);
		$deger = str_replace("#2;",">",$deger);
		return $deger;
	}
?>