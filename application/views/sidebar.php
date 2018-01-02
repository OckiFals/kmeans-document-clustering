<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>Muh Sholehhudin</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>


            <li class="<?php if ($this->uri->segment(1) == "daftarpaper") {
                echo "active";
            } ?>">
                <a href="<?php echo base_url('daftarpaper') ?>">
                    <i class="fa fa-edit"></i> <span>Data Skripsi</span>
                    <span class="pull-right-container">
              <!-- <i class="fa fa-angle-left pull-right"></i> -->
            </span>
                </a>
                <!-- <ul class="treeview-menu">

                </ul> -->
            </li>

            </li>
            <li class="<?php if ($this->uri->segment(1) == "treeview-menu") {
                echo "treeview active";
            } ?>">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Text Preprocessing</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">

                    <li class="<?php if ($this->uri->segment(1) == 'stopwords') {
                        echo "active";
                    } ?>">
                        <a href="stopwords"><i class="fa fa-circle-o"></i> StopWords</a></li>

                    <li class="<?php if ($this->uri->segment(1) == '') {
                        echo "active";
                    } ?>">
                        <a href="manual"><i class="fa fa-circle-o"></i> Manualisasi</a></li>


                </ul>
            </li>

            <li class="<?php if ($this->uri->segment(1) == "treeview-menu") {
                echo "treeview active";
            } ?>">
                <a href="#">
                    <i class="fa fa-table"></i> <span>Clustering</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">

                    <li class="<?php if ($this->uri->segment(1) == 'klustering') {
                        echo "active";
                    } ?>">
                        <a href="<?php echo base_url('klustering') ?>"><i class="fa fa-circle-o"></i> K-Means</a></li>

                </ul>
            </li>


        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<div class="content-wrapper">
</div>