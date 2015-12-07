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
                        $this->db->distinct();
                        $this->db->select('tahun');
                        $this->db->order_by("tahun", "desc");
                        $sql=$this->db->get('stki_top_tags'); 
                        foreach ($sql->result() as $row){
                          if($row->tahun==9999){
                            if($row->tahun==$tahun)
                              echo '<li><a style="color:white" href="'.base_url().'home/display_top_tags/'.$row->tahun.'">All the time</a></li>';
                            else
                              echo '<li><a  href="'.base_url().'home/display_top_tags/'.$row->tahun.'">All the time</a></li>';
                          }
                          else{
                            if($row->tahun==$tahun)
                              echo '<li><a  style="color:white" href="'.base_url().'home/display_top_tags/'.$row->tahun.'">'.$row->tahun.'</a></li>';
                            else
                              echo '<li><a  href="'.base_url().'home/display_top_tags/'.$row->tahun.'">'.$row->tahun.'</a></li>';
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
              
              <h1 style="text-align:center;">10 Top Tags 
                <?php
                  if($tahun==9999)
                    echo "All the time";
                  else
                    echo "in ".$tahun;
                ?>
              </h1>
              <div style="margin-left:90px;" class="col-lg-10 main-chart">
                  <div class="row mtbox">
                      <?php
                        //echo $tahun;
                        $sql=$this->db->get_where('stki_top_tags', array('tahun' => $tahun));
                        foreach ($sql->result() as $row){
                          echo '<div class="col-md-2 col-sm-2 box0">';
                          echo '<div class="box1"><span class="li_heart"></span>';
                          echo '<h3><a href="'.base_url().'home/list_documents_tag/'.$row->id.'">'.$row->tags.'</a></h3></div>';
                          echo '<p>'.$row->df.' documents have this tag</p></div>';
                          //echo $row->tags.' - ';
                        }
                      ?>
                        
                  </div>
              </div>
              
                        
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
