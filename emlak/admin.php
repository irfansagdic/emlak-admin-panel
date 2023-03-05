<?php 
	session_start();
	include("sistem/fonksiyon.php");
	include("siniflar/veritabani.php");
	uyeGirisKontrol();
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
  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">



  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="admin.php" class="logo">
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

  <aside class="main-sidebar">
    
    <section class="sidebar">
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Menüler</li>
        <li class="active">
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
        <small>Anasayfa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Yönetim</a></li>
        <li class="active">Anasayfa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
		 <div class="box">
            <div class="box-header">
              <h3 class="box-title">Tüm İlanlar</h3>
			  <form action = "" method = "post">
				<button type="submit" name ="csv" class ="btn btn-primary pull-right">Dışarı Aktar (CSV)</button>
			  </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
				<tr>
					<th>İlan Başlığı</th>
					<th>İlan İl</th>
					<th>İlan İlçe</th>
					<th>Detay</th>
					<th>Düzenle</th>
					<th>Sil</th>
                </tr>
                </thead>
                <tbody>
					<?php 
					$veritabani = new Veritabani();
					$ilanlar = $veritabani->ilanlariGetir();
					foreach($ilanlar as $veri)
					{
						
						echo
						'<tr>
							<td>'.$veri["baslik"].'</td>
							<td>'.$veri["il"].'</td>
							<td>'.$veri["ilce"].'</td>
							<td><a href ="'.URL.'detay/'.$veri["resimEmlakId"].'">Detay</a></td>
							<td><a href ="'.URL.'duzenle/'.$veri["resimEmlakId"].'">Düzenle</a></td>
							<td><a onClick=\'javascript: return confirm("İlanı Silmek İstiyor musunuz ?");\' href ="'.URL.'sil/'.$veri["resimEmlakId"].'">Sil</a></td>
						</tr>';
					}
				
					?>
                </tbody>
                <tfoot>
                <tr>
					<th>İlan Başlığı</th>
					<th>İlan İl</th>
					<th>İlan İlçe</th>
					<th>Detay</th>
					<th>Düzenle</th>
					<th>Sil</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
   
    <strong>İrfan Sağdıç </strong> &copy; 2022
  </footer>


  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
<?php 

	if(@$_GET["id"]) // sayfa get olmuşsa veri silmek istiyodur.
	{
		$id = guvenlik($_GET["id"]);
		$sil = $veritabani->ilaniSil($id);
		if($sil)
		{
			echo '
			<script>alert("Silme İşlemi Başarılı !");
					window.location.href = "'.URL.'admin"
			</script>
			';
		}
		else{
			echo '
			<script>alert("Hata !");
					window.location.href = "'.URL.'admin"
			</script>
			';
		}
	}
	if($_POST)
	{
		$csv = $veritabani->csvDosyasiOlustur();
		if($csv)
		{
			echo '
			<script>alert("CSV dosyası oluşturuldu");
					window.location.href = "'.URL.'admin"
			</script>
			';
		}
		else{
			echo '
			<script>alert("Hata !");
					window.location.href = "'.URL.'admin"
			</script>
			';
		}
	}
?>
