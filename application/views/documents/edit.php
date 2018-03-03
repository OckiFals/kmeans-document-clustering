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

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Ubah Paper Baru</h3>
                    </div>
                    <form class="form-horizontal" action="" method="post">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="judul_skripsi" class="col-sm-2   control-label">Judul Skripsi</label>

                                <div class="col-sm-10">
                                    <input type="text" name="judul_skripsi" class="form-control" id="judul_skripsi"
                                           placeholder="Masukkan Judul" value="<?php echo $document->judul ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="fakultas" class="col-sm-2 control-label">Fakultas</label>
                                <div class="col-sm-10">
                                    <!-- <input type="text" name="fakultas" class="form-control" id="fakultas"> -->
                                    <select class="form-control select2" id="fakultas" name="fakultas">
                                        <option value="Fakultas Ilmu Komputer" <?php echo ('Fakultas Ilmu Komputer' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Ilmu Komputer
										</option>
                                        <option value="Fakultas Hukum" <?php echo ('Fakultas Hukum' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Hukum
										</option>
                                        <option value="Fakultas Ekonomi dan Bisnis" <?php echo ('Fakultas Ekonomi dan Bisnis' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Ekonomi dan Bisnis
										</option>
                                        <option value="Fakultas Ilmu Administrasi" <?php echo ('Fakultas Ilmu Administrasi' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Ilmu Administrasi
										</option>
                                        <option value="Fakultas Pertanian" <?php echo ('Fakultas Pertanian' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Pertanian
										</option>
                                        <option value="Fakultas Peternakan" <?php echo ('Fakultas Peternakan' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Peternakan
										</option>
                                        <option value="Fakultas Teknik" <?php echo ('Fakultas Teknik' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Teknik
										</option>
                                        <option value="Fakultas Kedokteran" <?php echo ('Fakultas Kedokteran' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Kedokteran
										</option>
                                        <option value="Fakultas Perikanan dan Ilmu Kelautan" <?php echo ('Fakultas Perikanan dan Ilmu Kelautan' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Perikanan dan Ilmu Kelautan
										</option>
                                        <option value="Fakultas Matematika dan Ilmu Pengetahuan Alam" <?php echo ('Fakultas Matematika dan Ilmu Pengetahuan Alam' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Matematika dan Ilmu Pengetahuan Alam
										</option>
                                        <option value="Fakultas Teknologi Pertanian" <?php echo ('Fakultas Teknologi Pertanian' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Teknologi Pertanian
										</option>
                                        <option value="Fakultas Ilmu Sosial dan Ilmu Politik" <?php echo ('Fakultas Ilmu Sosial dan Ilmu Politik' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Ilmu Sosial dan Ilmu Politik
										</option>
                                        <option value="Fakultas Ilmu Budaya" <?php echo ('Fakultas Ilmu Budaya' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Ilmu Budaya
										</option>
                                        <option value="Fakultas Kedokteran Hewan" <?php echo ('Fakultas Kedokteran Hewan' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Kedokteran Hewan
										</option>
                                        <option value="Fakultas Kedokteran Gigi" <?php echo ('Kedokteran Gigi' == $document->fakultas) ? 'selected' : '' ?>>
											Fakultas Kedokteran Gigi
										</option>
                                    </select>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="tahun" class="col-sm-2   control-label">Tahun</label>

                                <div class="col-sm-10">
                                    <input type="number" name="tahun" class="form-control" id="tahun"
                                           placeholder="Masukkan Tahun Terbit Paper" value="<?php echo $document->tahun ?>">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tahun" class="col-sm-2   control-label">Abstrak</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="abstrak" id="abstrak" rows="15"
                                              placeholder="Masukkan Abstrak"><?php echo $document->abstrak ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="tahun" class="col-sm-2   control-label">Kata Kunci Abstrak</label>

                                <div class="col-sm-10">
                                    <input type="text" name="kata_kunci" class="form-control" id="katakunci"
                                           placeholder="Masukkan Kata Kunci Abstrak" value="<?php echo $document->kata_kunci ?>">
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
                                <label for="tahun" class="col-sm-2   control-label">Daftar Isi</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" name="daftar_isi" rows="15"
                                              placeholder="Masukkan Daftar Pustaka"><?php echo $document->daftar_isi ?></textarea>
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
                            <button type="" class="btn btn-default pull-left">
								<a href="<?php echo base_url() ?>">Lihat Tabel</a>
                            </button>
                            <button type="submit" class="btn btn-info pull-right">Simpan</button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>
