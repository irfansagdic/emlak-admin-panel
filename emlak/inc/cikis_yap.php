<?php 
	session_start();
	include("../sistem/fonksiyon.php");
	uyeGirisKontrol();
	unset($_SESSION["giris"]);
	echo "Çıkış Başarılı. Giriş Sayfasına Yönlendiriliyorsunuz";
	header("Refresh:1;url=".URL."giris");
	
?>