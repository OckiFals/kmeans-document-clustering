<?php 
if($kluster != "" || $kluster != null){
  include('application/views/test.php');
  echo 'kk';
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Form Data
        <small>Detail</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Masukkan Data</a></li>
        <li class="active">Data Skripsi</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        
          <!-- general form elements -->
          <!--  -->
          <!-- /.box -->

          <!-- Form Element sizes -->
          
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Klustering Skripsi</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="<?php echo base_url('main/proses')?>" method="POST">
              <div class="box-body">

              <div class="form-group">
                  <label for="inputJudul" class="col-sm-2   control-label">Jumlah K</label>

                  <div class="col-sm-10">
                    <input type="text" name="klustering" class="form-control" id="klustering" placeholder="Masukkan Jumlah Kluster">
                  </div>
                </div>
              <!-- <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2   control-label">Fakultas</label>
                  <div class="col-sm-10">
                  <select class="form-control select2">
                    <option>Fakultas Ilmu Komputer</option>
                    <option>Fakultas Hukum</option>
                    <option>Fakultas Ekonomi dan Bisnis</option>
                    <option>Fakultas Ilmu Administrasi</option>
                    <option>Fakultas Pertanian</option>
                    <option>Fakultas Peternakan</option>
                    <option>Fakultas Teknik</option>
                    <option>Fakultas Kedokteran</option>
                    <option>Fakultas Perikanan dan Ilmu Kelautan</option>
                    <option>Fakultas Matematika dan Ilmu Pengetahuan Alam</option>
                    <option>Fakultas Teknologi Pertanian</option>
                    <option>Fakultas Ilmu Sosial dan Ilmu Politik</option>
                    <option>Fakultas Ilmu Budaya</option>
                    <option>Fakultas Kedokteran Hewan</option>
                    <option>Fakultas Kedokteran Gigi</option>
                  </select>
                  </div>
                 
                </div> -->
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2   control-label">Total Skripsi</label>

                  <div class="col-sm-10">
                    <input type="ntext" class="form-control" id="jumlahskripsi" placeholder="" disabled>
                  </div>
                </div>
               


               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <!-- <button  class="btn btn-default"><a href="daftarpaper">Lihat Tabel</a></button> -->
                <button type="submit" class="btn btn-info pull-right">Hitung</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<section class="content">
      <div class="row">
        <!-- left column -->
        
          <!-- general form elements -->
          <!--  -->
          <!-- /.box -->

          <!-- Form Element sizes -->
          
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Klustering Skripsi</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal">
              <div class="box-body">

              <?php if($kluster != "" || $kluster != null){ ?>
              <table border="1" align="center">
                  <?php for ($i = 0; $i < $cluster_count; $i++) : ?>
                    <tr>
                      <td><b><center>C<?php echo $i+1 ?></center></b></td>
                      <?php foreach (array_keys($cluster_kmean['c'. ($i+1)]) as $key => $value) : ?>
                        <td><?php echo $value ?></td>
                      <?php endforeach; ?>
                    </tr>
                  <?php endfor; ?>
                </table>
             <br>

          <div class="row">
        <div class="col-xs-12">
          
          <!-- /.box -->

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Hasil Clustering</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
               

                    <tr>
                      <td style="width: 80px" rowspan="10"  align="center">Cluster 1</td>
                      <td style="width: 10px" rowspan="3">2015</td>
                      <td style="width: 10px">D1</td>
                      <td>PENGUNGKAPAN PENERAPAN TATA KELOLA KORPORAT PADA USAHA MIKRO, KECIL DAN MENENGAH (UMKM)</td>
                    </tr>
                    <tr>
                      <td>D2</td>
                      <td>ANALISIS KOMPETITOR LEMBAGA KEUANGAN SYARIAH: STUDI KASUS PADA KJKS BMT BINA INSAN MANDIRI TUBAN DAN BANK THITHIL DI KABUPATEN TUBAN</td>
                    </tr>
                    <tr>
                      <td> D3  </td>
                      <td>ANALISIS PENGARUH QUALITY SERVICE DAN BRAND IMAGE PADA KEPUTUSAN PEMBELIAN KONSUMEN TERHADAP LOYALITAS PELANGGAN</td>
                    </tr>
                    <tr>
                      <td rowspan="2"> 2016 </td>
                      <td>D4</td>
                      <td>FAKTOR-FAKTOR YANG MEMPENGARUHI LUAS PENGUNGKAPAN CORPORATE SOCIAL RESPONSIBILITY (CSR) DALAM LAPORAN TAHUNAN PERUSAHAAN </td>
                    </tr>
                    <tr>  
                      <td>D5</td>
                      <td>ANALISIS KINERJA MANAJEMEN RISIKO PEMBIAYAAN DAN PENGARUHNYA TERHADAP RETURN ON ASSET (ROA) PADA PT BANK SYARIAH MANDIRI </td>
                    </tr>
                    <tr>
                      <td rowspan="5">2017</td>
                      <td>D6</td>
                      <td>PERSEPSI DAN IDENTIFIKASI KEBUTUHAN PADA PROSES PENDAMPINGAN</td>
                    </tr>
                    <tr>
                     
                      <td>D7</td>
                      <td>PEMBERDAYAAN KELOMPOK MASYARAKAT PADA PENGELOLAAN PANTAI DELEGAN DI KABUPATEN GRESIK</td>
                    </tr>
                    <tr>
                    
                      <td>D8</td>
                      <td>Pengaruh Kredibilitas Celebrity Endorser Terhadap Purchase Intention (Studi Kasus Valentino Rossi Sebagai Celebrity Endorser Produk Yamaha Mio GT Pada Mahasiswa Universitas Brawijaya Malang)</td>
                    </tr>
                    <tr>
                     
                      <td>D9</td>
                      <td>Hubungan Kausalitas Antara Kurs Rupiah Terhadap Dolar Amerika Serikat Dengan Indeks Harga Saham Gabungan Periode 2009 – 2014. Skripsi, Jurusan Ilmu Ekonomi, Fakultas Ekonomi dan Bisnis, Universitas Br</td>
                    </tr>
                    <tr>
                      
                      <td>D10</td>
                      <td>PERBANDINGAN DAYA TAHAN BANK KONVENSIONAL DAN BANK SYARIAH DALAM MENGHADAPI KRISIS</td>
                    </tr>
                    <tr>
                      <td style="width: 80px" rowspan="10"  align="center">Cluster 2</td>
                      <td style="width: 10px" rowspan="3">2015</td>
                      <td style="width: 10px">D11</td>
                      <td>CLUSTERING MENGGUNAKAN METODE DBSCAN (DENSITY-BASED SPATIAL CLUSTERING OF APPLICATION WITH NOISE) UNTUK DATA HASIL SCREENING PANITIA PROBINMABA FAKULTAS</td>
                    </tr>
                    <tr>
                      <td>D12</td>
                      <td>PERANCANGAN REQUIREMENT ANTARMUKA WEB KOLABORASI MUSEUM BERBASIS USER-CENTERED DESIGN</td>
                    </tr>
                    <tr>
                      <td> D13  </td>
                      <td>IMPLEMENTASI FUZZY TOPSIS PADA QSPM (QUANTITATIVE STRATEGIC PLANNING MATRIX) UNTUK PEMILIHAN STRATEGI BISNIS PADA PERUSAHAAN</td>
                    </tr>
                    <tr>
                      <td rowspan="2"> 2016 </td>
                      <td>D14</td>
                      <td>SISTEM PENDUKUNG KEPUTUSAN DALAM PEMILIHAN KEMINATAN MENGGUNAKAN METODE FUZZY SIMPLE ADDITIVE WEIGHTED (STUDI KASUS: PROGRAM STUDI INFORMATIKA FAKULTAS ILMU KOMPUTER UNIVERSITAS BRAWIJAYA)</td>
                    </tr>
                    <tr>  
                      <td>D15</td>
                      <td>RANCANG BANGUN GAME EDUKASI PENERAPAN HUKUM NEWTON</td>
                    </tr>
                    <tr>
                      <td rowspan="5">2017</td>
                      <td>D16</td>
                      <td>IMPLEMENTASI ALGORITMA GENETIKA UNTUK OPTIMASI PEMERATAAN MUTASI GURU SD DI KABUPATEN BANYUWANGI</td>
                    </tr>
                    <tr>
                     
                      <td>D17</td>
                      <td>RANCANG BANGUN SISTEM MONITORING KONSUMSI LISTRIK BERBASIS WEB</td>
                    </tr>
                    <tr>
                    
                      <td>D18</td>
                      <td>RANCANG BANGUN SISTEM AKSES KONTROL RUANG LABORATORIUM DENGAN MENERAPKAN KUNCI MAGNETIK BERBASIS RFID (Studi Kasus : Program Teknologi Informasi Dan Komputer Universitas Brawijaya)</td>
                    </tr>
                    <tr>
                     
                      <td>D19</td>
                      <td>RANCANG BANGUN APLIKASI PENSTATUSAN SURAT PEMBERITAHUAN KEWAJIBAN PEMILIK KENDARAAN BERMOTOR (SPKPKB) BERBASIS ANDROID MENGGUNAKAN GPS (GLOBAL POSITIONING SYSTEM)</td>
                    </tr>
                    <tr>
                      
                      <td>D20</td>
                      <td>RANCANG BANGUN PROTOTYPE PENDETEKSI HIPOTERMIA PADA PENDAKI GUNUNG MENGGUNAKAN METODE FUZZY MAMDANI</td>
                    </tr>
                   
                    
              </table>
            </div>

            
            <!-- /.box-body -->
            <div class="box-footer clearfix">
            </div>
          </div>

        </div>
        <!-- /.col -->
      </div>
               

                 <?php } ?>
               

               
              </div>
              <!-- /.box-body -->
             
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->
          
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </section>

    

  </div>