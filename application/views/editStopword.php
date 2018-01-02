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
            <li class="active">Data Paper</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Masukkan Paper Baru</h3>
                    </div>

                    <form class="form-horizontal" action="" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="judul_skripsi" class="col-sm-2   control-label">Judul Skripsi</label>

                                <div class="col-sm-10">
                                    <input type="text" name="judul_skripsi" class="form-control" id="judul_skripsi"
                                           placeholder="Masukkan Judul">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="fakultas" class="col-sm-2 control-label">Fakultas</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" name="fakultas" class="form-control" id="fakultas"> -->
                                    <select class="form-control select2" id="fakultas" name="fakultas">
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

                            </div>
                            <div class="form-group">
                                <label for="tahun" class="col-sm-2   control-label">Tahun</label>

                                <div class="col-sm-10">
                                    <input type="number" name="tahun" class="form-control" id="tahun"
                                           placeholder="Masukkan Tahun Terbit Paper">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tahun" class="col-sm-2   control-label">Abstrak</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="abstrak" id="abstrak" rows="15"
                                              placeholder="Masukkan Abstrak"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tahun" class="col-sm-2   control-label">Kata Kunci Abstrak</label>

                                <div class="col-sm-10">
                                    <input type="text" name="kata_kunci" class="form-control" id="katakunci"
                                           placeholder="Masukkan Kata Kunci Abstrak">
                                </div>

                            </div>

                            <div class="form-group">

                                <label for="InputFile" class="col-sm-2 control-label"><!-- File input --></label>

                                <div class="col-sm-10">
                                    <input type="file" id="dokumen" name="dokumen">
                                </div>

                                <!-- <p class="help-block">Example block-level help text here.</p> -->
                            </div>

                            <div class="form-group">
                                <label for="tahun" class="col-sm-2   control-label">Daftar Pustaka</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="dapus" id="dapus" rows="15"
                                              placeholder="Masukkan Daftar Pustaka"></textarea>
                                </div>
                            </div>

                            <div class="form-group">

                                <label for="InputFile" class="col-sm-2 control-label"><!-- File input --></label>

                                <div class="col-sm-10">
                                    <input type="file" id="dokumen" name="dokumen">
                                </div>

                                <!-- <p class="help-block">Example block-level help text here.</p> -->
                            </div>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                            <button type="" class="btn btn-default pull-left"><a href="daftarpaper">Lihat Tabel</a>
                            </button>
                            <button type="submit" class="btn btn-info pull-right">Simpan</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>