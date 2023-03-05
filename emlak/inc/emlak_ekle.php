<?php 
	session_start();
	include("../sistem/fonksiyon.php");
	include("../siniflar/veritabani.php");
	uyeGirisKontrol();
	//üye girişi,tüm emlak listeleme ve sil düzenleme, konum, il , ilçe ,daire mi arsamı villamı,metre kare,kaç oda kaç salon,arama bölümü,csv
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Yönetim Paneli</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php  echo URL ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php  echo URL ?>bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php  echo URL ?>bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php  echo URL ?>dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php  echo URL ?>dist/css/skins/_all-skins.min.css">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php  echo URL ?>bower_components/morris.js/morris.css">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php  echo URL ?>bower_components/jvectormap/jquery-jvectormap.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php  echo URL ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php  echo URL ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php  echo URL ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <script>
		function duzenleme(){
	
			var emlakTipi = document.getElementById("tip").value;
			if(emlakTipi==2)//arsaysa
			{
				document.getElementById("oda").style.display="none";
				document.getElementById("soru1").style.display="none";	
				document.getElementById("oda").required = false;
					
				document.getElementById("salon").style.display="none";
				document.getElementById("soru2").style.display="none";	
				document.getElementById("salon").required = false;
					
			}
			else //arsa seçimi iptal edilmiş olabilir
			{
				document.getElementById("oda").style.display="inline";
				document.getElementById("soru1").style.display="inline";
				document.getElementById("oda").required = true;
					
				document.getElementById("salon").style.display="inline";
				document.getElementById("soru2").style.display="inline";
				document.getElementById("salon").required = true;
			}
		}
  </script>
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <script src="<?php echo URL ?>ckeditor/ckeditor.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="<?php echo URL ?>admin" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>Panel</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>Admin Panel</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menüler</li>
        <li class="">
          <a href="<?php echo URL ?>admin">
            <i class="fa fa-dashboard"></i> <span>Anasayfa</span>
          </a>
        </li>
		<li class="active">
          <a href="<?php echo URL ?>emlak-ekle">
            <i class="fa fa-files-o"></i> <span>Emlak Ekle</span>
          </a>
        </li>
		<li class="">
          <a href="<?php echo URL ?>ara">
            <i class="fa fa-edit"></i> <span>Arama</span>
          </a>
        </li>
		<li class="">
          <a href="<?php echo URL ?>cikis-yap">
            <i class="fa fa-sign-out"></i> <span>Çıkış Yap</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Emlak Yönetim Paneli
        <small>Emlak Ekle</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Yönetim</a></li>
        <li class="active">Emlak Ekleme</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Emlak Ekle</h3>
            </div>
			<div class="box-body">
				<form action="" method = "post" enctype="multipart/form-data" role="form">
					<div class="form-group">
					  <label>İlan Başlığını Giriniz:</label>
					  <input type="text" name = "baslik" minlength="5" required class="form-control" placeholder="İlan Başlığı">
					</div>
					<div class="form-group">
					  <label>İlan Açıklaması:</label>
					  <textarea name="aciklama" id="editor1" rows="10" cols="80" required placeholder="İlan Açıklaması" class="ckeditor">
						
					  </textarea>
					</div>
					<div class="form-group">
					  <label>İl Giriniz:</label>
					  <input type="text" name = "il" minlength="5" required class="form-control" placeholder="İl">
					</div>
					<div class="form-group">
					  <label>İlçe Giriniz:</label>
					  <input type="text" name = "ilce" minlength="5" required class="form-control" placeholder="İlce">
					</div>
					<div class="form-group">
					  <label>Emlak Tipini Seçiniz</label>
					  <select onchange="duzenleme()"  id="tip" name="tip" class="form-control" required>
						<option value ="1">Daire</option>
						<option value ="2">Arsa</option>
						<option value ="3">Villa</option>
					  </select>
					</div>
					<div class="form-group">
					  <label>Metrekare:</label>
					  <input type="number" name = "metrekare" minlength="5" required class="form-control" placeholder="Metrekare">
					</div>
					<div class="form-group">
					  <label id="soru1">Salon Sayısı:</label>
					  <input type="number" id="salon" name = "salon" minlength="5" required class="form-control" placeholder="Salon">
					</div>
					<div class="form-group">
					  <label id="soru2">Oda Sayısı:</label>
					  <input type="number" id="oda" name = "oda" minlength="5" required class="form-control" placeholder="Oda">
					</div>
					<div class="form-group">
					  <label id="soru2">Fiyat:</label>
					  <input type="text"  name = "fiyat" minlength="5" required class="form-control" placeholder="Fiyat">
					</div>
					<div class="form-group">
					  <label id="soru2">İlan Sahibi Telefon Numarası:</label>
					  <input type="text"  name = "tel" minlength="13" required class="form-control" pattern="[0-9]{3} [0-9]{3} [0-9]{2} [0-9]{2}" placeholder="Format : XXX XXX XX XX">
					</div>
					<div class="form-group">
						<label for="exampleInputFile">İlanınıza Ait Resimleri Yükleyin:</label>
						<input type="file" name = "dosya[]" required multiple id="exampleInputFile">
					</div>
					<div class="form-group">
					  <label>Konum:</label>
					  <textarea class="form-control" rows="3" name="konum" placeholder="Link olarak girin"></textarea>
					</div>
					<div class="box-footer">
						<button type="submit" class="btn btn-primary">Emlak Kayıt Et</button>
					</div>
				</form>
			</div> 

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
   
    <strong>İrfan Sağdıç </strong> &copy; 2022
  </footer>



  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo URL ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo URL ?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo URL ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="<?php echo URL ?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?php echo URL ?>dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo URL ?>dist/js/demo.js"></script>
</body>
</html>
	<?php 
		if($_POST)
		{
			$resimTurKontrol = array("image/jpeg","image/jpg","image/png");
			$turKontrol = true;
			if(count($_FILES["dosya"]["name"])>=2)
			{
				foreach($_FILES["dosya"]["name"] as $i=>$name)
				{
					if(in_array($_FILES["dosya"]["type"][$i],$resimTurKontrol))
					{
						$turKontrol = true;
						
					}
					else{
						//eğer resim dışında başka dosya varsa kayıt işlemini iptal et
						$turKontrol = false;
						break;
					}
				}
				if($turKontrol == false)
				{
					echo '<script>alert("Dosyalarınız png ve jpg türünde olmalıdır");
										window.location.href = "'.URL.'/emlak-ekle"
								  </script>';
			
				}
				else
				{ 	//dosyaları resimdir kayıt işlemini başlatalım.
					
					$baslik = guvenlik($_POST["baslik"]);
					$aciklama = guvenlik(etiketTemizleme($_POST["aciklama"]));
					$il = guvenlik($_POST["il"]);
					$ilce = guvenlik($_POST["ilce"]);
					$tip = guvenlik($_POST["tip"]);
					$metrekare = guvenlik($_POST["metrekare"]);
					$oda = guvenlik($_POST["oda"]);
					$salon = guvenlik($_POST["salon"]);
					$fiyat = guvenlik($_POST["fiyat"]);
					$tel = guvenlik($_POST["tel"]);
					$konum = filter_input(INPUT_POST,"konum",FILTER_SANITIZE_URL);
					//$konum = guvenlik($_POST["konum"],FILTER_SANITIZE_URL);
					$tarih = date("d-m-Y H:i");
					if($oda == null && $salon == null)//oda ve salon boşsa emlak tipi arsadır.
					{
						$oda = 0;
						$salon = 0;
					}
					
					$ekleSutunlari = array("baslik","aciklama","il","ilce","emlakTipi","metrekare","oda","salon","konum","fiyat","tel","tarih");
					$ekleDegerleri = array($baslik,$aciklama,$il,$ilce,$tip,$metrekare,$oda,$salon,$konum,$fiyat,$tel,$tarih);
					
					$kayit = new Veritabani();
					$sonuc = $kayit ->veriKayit("ilanlar",$ekleSutunlari,$ekleDegerleri);
					if($sonuc)//veriler kayıt edilmiştir, fotoğraflara geçebiliriz
					{
						$id = $kayit->sonKayitEdilenId();
						$resimSutunlari = array("resimAd","resimEmlakId");
						foreach($_FILES["dosya"]["name"] as $i=>$name)
						{
							$duzgunIsim = isimDuzelt($name);//resmin türü yok burda
							$resimDegerleri = array($duzgunIsim,$id);
							$resimSonuc = $kayit->veriKayit("resimler",$resimSutunlari,$resimDegerleri);
							$resimDosyaKayit = move_uploaded_file($_FILES["dosya"]["tmp_name"][$i],"../resimler/".$duzgunIsim);
						}
						if($resimSonuc && $resimDosyaKayit)
						{
							echo '<script>alert("Resimler ve Emlak Kaydınız Başarıyla Eklenmiştir.Yönlendiriliyorsunuz !");
										window.location.href = "'.URL.'/emlak-ekle"
								</script>';
							
						}
						else
						{
							echo '<script>alert("Resimler eklenirken hata oluştu");
										window.location.href = "'.URL.'/emlak-ekle"
								  </script>';
						}
						
					}
					else
					{
						echo '<script>alert("Hata oluştu.Tekrar yönlendiriliyorsunuz");
										window.location.href = "'.URL.'/emlak-ekle"
								  </script>';
					}
				}
				
			}
			else{
				echo '<script>alert("En az 2 dosyanız olmalı");
										window.location.href = "'.URL.'/emlak-ekle"
						</script>';
			}
		}
		
	?>
