<?php 
	session_start();
	include("../sistem/fonksiyon.php");
	include("../siniflar/veritabani.php");
	uyeGirisKontrol();
	if(!($_GET))//Sayfa get değilse üstten girilmistir
	{
		header("Location:http://localhost/emlak/admin.php");
	}
	$emlakId = guvenlik($_GET["id"]);
	$veritabani = new Veritabani();
	$veri = $veritabani->ilanBilgileriniGetir($emlakId);
	if($veri == null) //böyle bir veri yoksa anasayfa gönder
	{
		header("Location:http://localhost/emlak/admin.php");
	}
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
  <link rel="stylesheet" href="../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">





  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body  class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="../admin.php" class="logo">
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
		<li class="">
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
        <small>Emlak Detay</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Yönetim</a></li>
        <li class="active">Emlak Detay</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Emlak Detayları</h3>
            </div>
			<div class="box-body">
				<label>İlanın Eklendiği Tarih: </label><?php echo $veri["tarih"]?><br>
				<label>Emlak Tipi: </label><?php echo $veri["ilanTur"]?><br>
				<label>Bulunduğu İl: </label><?php echo $veri["il"]?><br>
				<label>Bulunduğu İlçe: </label><?php echo $veri["ilce"]?><br>
				<?php 
				if($veri["ilanTur"] != "Arsa")
				{
				?>
					<label>Salon Sayısı: </label><?php echo $veri["salon"]?><br>
					<label>Oda Sayısı: </label><?php echo $veri["oda"]?><br>
				<?php 
				}
				?>
				<label>Metrekare: </label><?php echo $veri["metrekare"]?> m²<br>
				<label>Emlak Konumu : </label><a target="_blank" href ="<?php echo $veri["konum"] ?>">Tıkla</a><br>
				<label>Fiyat : </label><?php echo $veri["fiyat"]?><br>
				<label>Sahibinin İletişim Bilgileri : </label><?php echo $veri["tel"]?><br>
				<label>İlan Aciklaması : </label><br><hr><span class="box-body"><?php echo etkiketYazdir($veri["aciklama"]);?></span><hr><br><br>
				
				<label>Bu ilana ait fotoğraflar:</label><br>
				<?php 
				$resimler = $veritabani -> ilanaAitResimler($emlakId);
				foreach($resimler as $resim)
				{
					echo '<a target="_blank" href = "../resimler/'.$resim["resimAd"].'" ><img style="width:150px; height:150px; margin:20px; padding:20px;" src ="../resimler/'.$resim["resimAd"].'"></a>';
					
				}				
				?>
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
<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>

		
