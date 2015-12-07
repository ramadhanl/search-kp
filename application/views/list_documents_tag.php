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
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/search-kp/lineicons/style.css">    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
                      <a href="<?php echo base_url(); ?>">
                          <i class="fa fa-dashboard"></i>
                          <span>Pencarian laporan KP</span>
                      </a>
                  </li>

                  <li class="sub-menu">
                      <a class="active"  href="javascript:;" >
                          <i class="fa fa-desktop"></i>
                          <span>Top Tags</span>
                      </a>
                      <ul class="sub">
                      <?php
                        $sql2=$this->db->get_where('stki_top_tags', array('id' => $id_tag));
                          foreach ($sql2->result() as $row2) { $tahun=$row2->tahun;}
                        $this->db->distinct();
                        $this->db->select('tahun');
                        $this->db->order_by("tahun", "desc");
                        $sql=$this->db->get('stki_top_tags'); 
                        foreach ($sql->result() as $row){
                          if($row->tahun==9999){
                            if($row->tahun==$tahun)
                              echo '<li><a style="color:white" href="'.base_url().'home/display_top_tags/'.$row->tahun.'"><span>All the time</span></a></li>';
                            else
                              echo '<li><a href="'.base_url().'home/display_top_tags/'.$row->tahun.'"><span>All the time</span></a></li>';
                          }
                          else{
                            if($row->tahun==$tahun)
                              echo '<li><a style="color:white" href="'.base_url().'home/display_top_tags/'.$row->tahun.'">'.$row->tahun.'</a></li>';
                            else
                              echo '<li><a href="'.base_url().'home/display_top_tags/'.$row->tahun.'">'.$row->tahun.'</a></li>';
                          }
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
              
              <h3>Daftar laporan kerja praktek dengan tag <font class="tag-big">
                <?php
                  $sql=$this->db->get_where('stki_top_tags', array('id' => $id_tag));
                  foreach ($sql->result() as $row) { $tag=$row->tags;$tahun=$row->tahun;}
                  echo $tag;
                ?>
                </font>
                <?php 
                  if($tahun==9999)
                    echo 'di semua data <font class="tag-big">';
                  else
                    echo 'di tahun <font class="tag-big">'.$tahun;?>
                </font>
              </h3>
              <?php 
                  $sql=$this->db->get_where('stki_tags_reference', array('id_tag' => $id_tag));
                  foreach ($sql->result() as $row) {
                    $sql2=$this->db->get_where('stki_data_kp', array('id_doc' => $row->id_doc));
                    foreach ($sql2->result() as $row2) {
                      echo '<div class="result">';
                      echo '<p class="judul"><a href="http://rbtc.if.its.ac.id/v3/index.php?p=show_detail&id='.$row2->id_doc.'">'.$row2->judul.'</a></p>';
                      echo '<p class="penulis">Penulis : '.$row2->penulis.'</p>';
                      echo '<p class="tags">Tahun terbit : '.$row2->tahun.'</p>';
                    }
                  }
              ?>
              
                        
                  </div><!-- /row mt -->  
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
