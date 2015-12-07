<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Search KP</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/search-kp/css/bootstrap.css" rel="stylesheet">
        
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/search-kp/css/kp.css" rel="stylesheet">
	<script src="<?php echo base_url(); ?>assets/search-kp/js/chart-master/Chart.js"></script>
	<script src="<?php echo base_url(); ?>assets/search-kp/js/kp.js"></script>

  </head>

  <body>
  	<div class="nav-search" id="nav-search">
      <form action="<?php echo base_url(); ?>home/search" method="POST">
        <input type="text" name="searchbox" class="search-box" id="searchbox">
    		<input type="submit" value="Search" class="search-button">
      </form>
  	</div>
    <div class="col-md-1"></div>
    <div class="col-md-8 search-result" id="search-result">
    <?php 
        $this->db->where('score >', '0');
        $this->db->order_by("score", "desc");
        $this->db->limit(10);
        $sql=$this->db->get('stki_search_results');
        foreach ($sql->result() as $row) {
          echo '<div class="result">';
          echo '<p class="judul">'.$row->judul.'</p>';
          echo '<p class="penulis">Penulis : '.$row->penulis.'</p>';
          echo '<p class="tags">Tahun terbit : '.$row->tahun.'</p>';
        }
    ?>
      <div class="result">
        <p class="judul">Pembuatan Aplikasi Komoditas Produk Jenis Usaha Berbasis Web dan System Integration Testing pada Aplikasi SIP SP dan SIMAKRO di Bank Indonesia</p>
        <p class="pengarang">Pengarang : Andhik Ampuh Yunanto NRP 5111100067 - Muhammad Iqbal Rustamadji NRP 5111100701</p>
        <p class="tags">2014 - Tags : System Integration, Bank Indonesia</p>
      </div>
    </div>
	<!-- <div class="search" id="search">
		<img src="<?php echo base_url(); ?>assets/search-kp/img/logo.jpg"><br>
		<form>
		<input type="text" class="search-box" id="searchbox" onkeyup="searchStart()">
		<input type="submit" value="Search" class="search-button">
		</form>
		<a href="#" class="populer"> Topik Terpopuler</a>
		<script type="text/javascript">
			function searchStart() {
				var todays_date = new Date();
				document.getElementById('nav-search').innerHTML = todays_date;
				//document.body.writeln('<input type="text" class="search-box" id="search" onkeyup="searchStart()"><input type="submit" value="Search" class="search-button">');
			}
		</script>
		<!-- <span class="glyphicon glyphicon-search" aria-hidden="true"></span> -->
	</div>
  </body>
</html>
