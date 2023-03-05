<?php 

	class Veritabani{
		private $host;
		private $user;
		private $pass;
		private $db;
		private $baglan;
		private $sonEklenenId;
		
		public function __construct(){
			
			$this->host="localhost";
			$this->kullanici="irfan";
			$this->sifre="9my4P7-3f-(]7Yel";
			$this->db="emlak";
			
		}
		public function __destruct(){
			$this->baglan = null;
		}
		
		private function baglantiAc(){
			try
			{	
				$this->baglan = new PDO("mysql:host=".$this->host.";dbname=".$this->db.";charset=utf8",$this->kullanici,$this->sifre);
				$this->baglan->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			
			}
			catch (PDOExpception $e)
			{
				echo $e->getMessage();
			}
		
		}
		public function uyeGiris($kullaniciAdi,$sifre){
			
			$this->baglantiAc();
			$sorgu = $this->baglan->prepare("SELECT * FROM uyeler WHERE kullanici = ? && sifre = ?");
			$sorgu->execute(array($kullaniciAdi,$sifre));
			$kayitSay = $sorgu->rowCount();
			return $kayitSay;
			
		}
		public function veriKayit($tablo,$sutun,$deger){
			$this->baglantiAc();
			$sutunlar = implode(",",$sutun);
			$degerler = implode("','",$deger);
			$soruIsareti = implode(',', array_fill(0, count($deger), '?'));
			$sorgu = $this->baglan->prepare("INSERT INTO $tablo (".$sutunlar.") VALUES ('".$degerler."')");
			$ekle = $sorgu->execute($deger);
			$this->sonEklenenId = $this->baglan->lastInsertId();//bazen lazım olabilir 
			if($ekle)
			{	
				return true;
			}
			else{
				return false;
			}
		
			
		}
		public function sonKayitEdilenId(){
			
			$id = $this->sonEklenenId;
			return $id;
			
		}
		public function ilanlariGetir()
		{
			$this->baglantiAc();
			$sorgu=$this->baglan->query("SELECT * FROM ilanlar AS I INNER JOIN ilanturleri AS IT ON I.emlakTipi = IT.id
																INNER JOIN resimler AS R ON I.id = R.resimEmlakId GROUP BY R.resimEmlakId ORDER BY resimEmlakId DESC",PDO::FETCH_ASSOC);
			return $sorgu;
		}
		public function ilanBilgileriniGetir($id)
		{
			$this->baglantiAc();
			$sorgu = $this->baglan->prepare("SELECT * FROM ilanlar AS I INNER JOIN ilanturleri AS IT ON I.emlakTipi = IT.id WHERE I.id = ?");
			$sorgu ->execute(array($id));
			$satir = $sorgu->fetch(PDO::FETCH_ASSOC);
			return $satir;
			
		}
		public function ilanaAitResimler($id)
		{
			$this->baglantiAc();
			$sorgu = $this->baglan->prepare("SELECT * FROM resimler WHERE resimEmlakId = ?");
			$sorgu->execute(array($id));
			$satir = $sorgu->fetchAll();
			return $satir;
		}
		public function resimSayisi($id)
		{
			$this->baglantiAc();
			$sorgu = $this->baglan->prepare("SELECT * FROM resimler WHERE resimEmlakId = ? ");
			$sorgu->execute(array($id));
			$kayitSay = $sorgu->rowCount();
			return $kayitSay;
		}
		public function resimSil($id)
		{
			$this->baglantiAc();
			$sorgu = $this->baglan->prepare("SELECT * FROM resimler WHERE id = ?");
			$sorgu ->execute(array($id));
			$satir = $sorgu->fetch(PDO::FETCH_ASSOC);
			$resimAd = $satir["resimAd"]; //dosyayı silmek için adını aldık ve sorgulama yaptik
			if($resimAd)//böyle bir resim var
			{
				$sorgu2 = $this->baglan->prepare("DELETE FROM resimler WHERE id = ?");
				$sil = $sorgu2 ->execute(array($id));
				if($sil) //silme işlemi başarılıysa dosyalari silicez
				{
					$dosyaSil = unlink($_SERVER["DOCUMENT_ROOT"].'/emlak/resimler/'.$resimAd); 
					if($dosyaSil)
					{
						return true;
					}
					else{
						return false;
					}
				}
				else{
					return false;
				}
				
			}
			else{
				return false;
			}
		}
		public function veriGuncelle($baslik,$aciklama,$il,$ilce,$tip,$metrekare,$oda,$salon,$konum,$fiyat,$tel,$id){
			$this->baglantiAc();
			$sorgu = $this->baglan->prepare("UPDATE ilanlar SET baslik = ? , aciklama=?, il = ? ,ilce = ? , emlakTipi = ? ,metrekare = ?, oda = ? ,salon = ?,konum = ?, fiyat = ?,tel = ?
											WHERE id = ?");
			$guncelle = $sorgu->execute(array($baslik,$aciklama,$il,$ilce,$tip,$metrekare,$oda,$salon,$konum,$fiyat,$tel,$id));
			if($guncelle)
			{
				return true;
			}
			else{
				return false;
			}
			
		}
		public function ilaniSil($id)
		{
			$this->baglantiAc();
			$sorgu = $this->baglan->prepare("DELETE FROM ilanlar WHERE id = ?");
			$veriSil = $sorgu -> execute(array($id));
			if($veriSil) //resimleri ve resimler tablosunu siliniyor
			{
				$resimler = $this->ilanaAitResimler($id); //bu ilana ait resimlerin hepsi
				foreach($resimler as $resim) //resimleri ve dosyalari siliyoruz
				{
					$sil = $this-> resimSil($resim["id"]);
				}
				if($sil)
				{
					return true;
				}
				else{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		public function arama($baslik,$il,$ilce,$tip,$metrekare,$oda,$salon)
		{
			$sorguCumlesi = ""; //textden gelen verilere göre sql cümlesi için
			if($baslik !=null)
			{
				$sorguCumlesi.="baslik LIKE '%$baslik%' AND "; 
			}
			if($il != null)
			{
				$sorguCumlesi.="il LIKE '%$il%' AND ";
			}
			if($ilce != null)
			{
				$sorguCumlesi.="ilce LIKE '%$ilce%' AND ";
			}
			if($metrekare != null)
			{
				$sorguCumlesi.="metrekare = $metrekare AND ";
			}
			if($oda != null)
			{
				$sorguCumlesi.= "oda = $oda AND ";
			}
			if($salon!=null)
			{
				$sorguCumlesi.="salon = $salon AND ";
			}
			if($tip != null)
			{
				$sorguCumlesi.="emlakTipi = $tip";
			}
			$this->baglantiAc();
			$sorgu=$this->baglan->query("SELECT * FROM ilanlar AS I INNER JOIN ilanturleri AS IT ON I.emlakTipi = IT.id
									INNER JOIN resimler AS R ON I.id = R.resimEmlakId  WHERE $sorguCumlesi  GROUP BY R.resimEmlakId",PDO::FETCH_ASSOC);
			return $sorgu;	

		}
		
		public function csvDosyasiOlustur()
		{
			touch("ilanlar.csv");
			$dosya = fopen("ilanlar.csv","wbt");
			$ilanlar = $this->ilanlariGetir();
			foreach($ilanlar as $veri)
			{
				$resimler = "";
				$emlakId = $veri["resimEmlakId"];
				$ilanResimleri = $this->ilanaAitResimler($emlakId);
				foreach($ilanResimleri as $resim)//ilana ait resimleri almak için
				{
					$resimler.=$resim["resimAd"].";"; 
				}
				
				$satir = fwrite($dosya,$veri["baslik"].";".$veri["il"].";".$veri["ilce"].";".$veri["ilanTur"].";".$veri["metrekare"].";".$veri["oda"].";".$veri["salon"].";".$veri["fiyat"].";".$veri["tel"].";".$veri["tarih"].";".$veri["konum"].";".$resimler." \n");
			}
			fclose($dosya);
			if($satir)
			{
				return true;
			}
			else{
				return false;
			}
			
		}
		
		
	}

?>