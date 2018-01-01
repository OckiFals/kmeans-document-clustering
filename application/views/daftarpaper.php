 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tabel Data Skripsi
        <small>Universitas Brawijaya</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="forminput"><i class="fa fa-dashboard"></i> Home</a></li>
        <!-- <li><a href="#">Masukkan Data</a></li> -->
        <li class="active">Data Skripsi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <!-- /.box -->

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Skripsi</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                  <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th style="width: 10px">No</th>
                  <th style="width: 50px">Judul Skripsi</th>
                  <th style="width: 50px">Tahun</th>
                  <th style="width: 50px">Fakultas</th>
                  <th style="width: 50px">Action</th>
                </tr>

                <?php
                $no = 1;
                foreach ($query as $row) {
                ?>

                <tr>
                  <td><?php echo $no++ ?></td>
                  <td><?php echo $row->judul_skripsi ?></td>
                  <td><span class="badge bg-red"><?php echo $row->tahun ?></span></td>
                  <td><?php echo $row->fakultas ?></td>
                  <td><div class="" align="left">
                          <!-- <button class="glyphicon glyphicon-pencil" style="width: 30px; height: 25px;"></button> -->
                         
                         <!--  <a href="#" class="btn btn-default btn-sm" data-href="<?php echo base_url();?>tambah_dokumenskripsi/hapus_dokumen/<?php echo $row->id_dokumen;?>"
                               data-toggle="modal" data-target="#delete-confirm">
                                <i class="fa fa-trash-o"></i>Hapus Artikel
                            </a> -->
                            <!-- < --><!-- a href="#"><button class="glyphicon glyphicon-trash" data-href="<?php echo base_url();?>tambah_dokumenskripsi/hapus_dokumen/<?php echo $row->id_dokumen;?>" data-toogle="modal" data-target="#delete-confirm" style="width: 30px; height: 25px; " ></button></a>
 -->

                        
                             <?php echo anchor('delete_dokumenskripsi/hapus/'.$row->id_dokumen,'<button class="glyphicon glyphicon-trash" style="width: 30px; height: 25px;"></button>'); ?>
                  <!-- <a href="< .$this->config->base_url().'tambah_dokumenskripsi/hapus_dokumen/'.id_dokumen->id_dokumen ">  -->
                                

                                                        
                      </div>
                  </td>
                </tr>
                    <?php  } ?> 
              
                
              </table>
            </div>
            <div class="box-footer clearfix">
              <a href="forminput"><button type="" class="btn btn-info pull-right"> Tambahkan Data</button></a>
            </div>
            <!-- /.box-body -->
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
