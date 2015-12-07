<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Search KP - RBTC</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/search-kp/css/bootstrap.css" rel="stylesheet">
    <!--external css-->
    <link href="<?php echo base_url(); ?>assets/search-kp/font-awesome/css/font-awesome.css" rel="stylesheet" />
        
    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/search-kp/css/style.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/search-kp/css/style-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/search-kp/css/kp.css" rel="stylesheet">
  </head>

  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>Search-KP</b></a>
            <!--logo end-->
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
              
                  <p class="centered"><a href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/search-kp/img/rbtc.jpg" class="img-square" width="170"></a></p>
                  <!-- <h5 class="centered">STKI</h5> -->
                    
                  <li class="mt">
                      <a class="active" href="<?php echo base_url(); ?>">
                          <i class="fa fa-dashboard"></i>
                          <span>Pencarian laporan KP</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-desktop"></i>
                          <span>Top Tags</span>
                      </a>
                      <ul class="sub">
                      <?php
                        $this->db->distinct();
                        $this->db->select('tahun');
                        $this->db->order_by("tahun", "desc");
                        $sql=$this->db->get('stki_top_tags'); 
                        foreach ($sql->result() as $row){
                          if($row->tahun==9999)
                            echo '<li><a  href="'.base_url().'home/display_top_tags/'.$row->tahun.'">All the time</a></li>';
                          else
                            echo '<li><a  href="'.base_url().'home/display_top_tags/'.$row->tahun.'">'.$row->tahun.'</a></li>';
                        }
                      ?>
                      </ul>
                  </li>

              </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
            <div class="row mt">
              <div class="col-lg-12">
              <?php
                if ($query!=4869) {
                  echo '<div class="nav-search" id="nav-search">
                          <form action="'.base_url().'home/search" method="POST">
                            <input type="text" name="searchbox" class="search-box" id="searchbox">
                            <input type="submit" value="Search" class="search-button">
                          </form>
                        </div>
                        <div class="col-md-8 search-result" id="search-result">';
                  echo '<h4>Hasil pencarian dengan query :  <i>'.str_ireplace('%20', " ", $query).'</i> </h4>';
                  $this->db->where('score >', '0');
                  $this->db->order_by("score", "desc");
                  //$this->db->limit(10);
                  $sql=$this->db->get('stki_search_results');
                  $result=$sql->num_rows();
                  echo "<p style='color:grey;font-size:12px;'>Didapatkan ".$result." data laporan kerja praktek yang sesuai (".$totaltime." detik)</p>";
                  $count=0;
                  foreach ($sql->result() as $row) {
                    echo '<div class="result">';
                    echo '<p class="judul"><a href="http://rbtc.if.its.ac.id/v3/index.php?p=show_detail&id='.$row->id_doc.'">'.$row->judul.'</a></p>';
                    echo '<p class="penulis">Penulis : '.$row->penulis.'</p>';
                    echo '<p class="tags">Tahun terbit : '.$row->tahun.'</p>';
                    $count++;
                  }
                }
                else{
                  echo '<div style="margin-top:250px;" class="nav-search" id="nav-search">
                          <form action="'.base_url().'home/search" method="POST">
                            <input type="text" name="searchbox" class="search-box" id="searchbox">
                            <input type="submit" value="Search" class="search-button">
                          </form>
                        </div>
                        <div class="col-md-8 search-result" id="search-result">';
                }
              ?>
              </div>
              </div>
            </div>
      
    <!-- js placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url(); ?>assets/search-kp/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/search-kp/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/search-kp/js/jquery-ui-1.9.2.custom.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/search-kp/js/jquery.ui.touch-punch.min.js"></script>
    <script class="include" type="text/javascript" src="<?php echo base_url(); ?>assets/search-kp/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="<?php echo base_url(); ?>assets/search-kp/js/jquery.scrollTo.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/search-kp/js/jquery.nicescroll.js" type="text/javascript"></script>


    <!--common script for all pages-->
    <script src="<?php echo base_url(); ?>assets/search-kp/js/common-scripts.js"></script>

    <!--script for this page-->
    
  <script>
      //custom select box

      $(function(){
          $('select.styled').customSelect();
      });

  </script>

  </body>
</html>
