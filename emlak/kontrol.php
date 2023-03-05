<?php 
	include("sistem/fonksiyon.php");
	session_start();
	if($_POST)
		{
			
			include("siniflar/veritabani.php");
			$email = guvenlik($_POST["email"]);
			$sifre = guvenlik($_POST["password"]);
			
			$sinif = new Veritabani();
			$sonuc = $sinif->uyeGiris($email,$sifre);
			if($sonuc>0)
			{
				echo "Üye Girişi Başarılı.Admin Sayfasına yönlendiriliyorsunuz";
				$_SESSION["giris"] = md5(sha1(md5("oke")));
				header("Refresh:1;url=".URL."admin");
				
			}
			else{
				echo "Kullanıcı adı veya şifre yanlış.Giriş Paneline Yönlendiriliyorsunuz";
				header("Refresh:1;url=".URL."giris");
			}
		}
		else{
		
			uyeGirisKontrol();
		}


?>