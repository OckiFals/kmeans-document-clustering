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

    <!-- Data form content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Klustering Skripsi</h3>
                    </div>
                    <form class="form-horizontal" action="" method="GET">
                        <div class="box-body">

                            <div class="form-group">
                                <label for="klustering" class="col-sm-2 control-label">Jumlah K</label>
                                <div class="col-sm-10">
                                    <input type="number" name="kluster" class="form-control" id="klustering"
                                           placeholder="Masukkan Jumlah Kluster" value="<?php echo $kluster ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Total Skripsi</label>

                                <div class="col-sm-10">
                                    <input type="text" class="form-control" placeholder="<?php echo $doc_count ?>" disabled>
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
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->

    <!-- Clustering results -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Klustering Skripsi</h3>
                    </div>
                    <div class="box-body">

                            <?php if (isset($cluster_kmean)) : ?>
                                <?php $hasil_clustering = []; ?>
                                <table border="1" align="center">
                                    <?php for ($i = 0; $i < $kluster; $i++) : ?>
                                        <?php $hasil_clustering[] = array_key_exists('c' . ($i + 1), $cluster_kmean) ?
                                            array_values($cluster_kmean['c' . ($i + 1)]) : '' ?>
                                        <tr>
                                            <td><b>
                                                    <center>C<?php echo $i + 1 ?></center>
                                                </b></td>
                                            <?php if (array_key_exists('c' . ($i + 1), $cluster_kmean)): ?>
                                            <?php foreach (array_keys($cluster_kmean['c' . ($i + 1)]) as $key => $value) : ?>
                                                <td><?php echo $value ?></td>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                                <td></td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endfor; ?>
                                </table>
                                <br>
                                <div class="col-xs-12">

                                    <!-- /.box -->
                                    <div class="box">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Hasil Clustering</h3>
                                        </div>
                                        <!-- /.box-header -->
                                        <div class="box-body">
                                            <table class="table table-bordered">
                                                <?php for ($i = 0; $i < $kluster; $i++) : ?>
                                                    <?php if (array_key_exists('c' . ($i + 1), $cluster_kmean)): ?>
                                                        <?php
                                                        $sql = "(";

                                                        foreach (array_keys($cluster_kmean['c' . ($i + 1)]) as $key => $value) {
                                                            $sql .= ($abstrak_id[$value]);

                                                            if ($key + 1 == count($cluster_kmean['c' . ($i + 1)])) {
                                                                $sql .= ')';
                                                            } else {
                                                                $sql .= ',';
                                                            }
                                                        }

                                                        $result = $this->Document_model->filterIN($sql);

                                                        foreach ($result as $index => $doc) : ?>
                                                            <tr>
                                                                <?php if (0 == $index) : ?>
                                                                    <td style="width: 80px"
                                                                        rowspan="<?php echo count($cluster_kmean['c' . ($i + 1)]) ?>"
                                                                        align="center">
                                                                        Cluster <?php echo $i + 1 ?>
                                                                    </td>
                                                                <?php endif; ?>
                                                                <td style="width: 10px"><?php echo $doc->tahun ?></td>
                                                                <td style="width: 10px">
                                                                    <?php echo strtoupper($hasil_clustering[$i][$index]); ?>
                                                                </td>
                                                                <td><?php echo $doc->judul ?></td>
                                                            </tr>
                                                        <?php endforeach ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td style="width: 80px">Cluster <?php echo $i + 1 ?></td>
                                                            <td style="width: 10px">-</td>
                                                            <td style="width: 10px">-</td>
                                                            <td>-</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endfor; ?>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- /.col -->
                                </div>
                            <?php endif ?>
                        </div>
                    <div class="box-footer">
                        <form action="" method="GET">
                            <input type="number" name="kluster" hidden="hidden" value="<?php echo $kluster ?>">
                            <input type="text" name="stage" hidden="hidden" value="silhoutte-test">
                            <button type="submit" class="btn btn-info pull-right">Uji</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  Silhouette test -->
    <?php if (isset($silhoutte_results)) : ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Silhouette Test</h3>
                    </div>
                    <div class="box-body">
                        <div class="row">
                            <!-- average-a -->
                            <div class="col-xs-6">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Rata-rata Jarak Dalam Satu Cluster</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table class="table table-bordered">
                                            <?php foreach ($silhoutte_results['average_a'] as $key => $value) : ?>
                                                <tr>
                                                    <td>a(<?php echo $key ?>)</td>
                                                    <td><?php echo $value ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /average-a -->

                            <!-- average-b -->
                            <div class="col-xs-6">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Rata-rata Jarak Dokumen Antar Cluster</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table class="table table-bordered">
                                            <?php foreach ($silhoutte_results['average_b'] as $key => $value) : ?>
                                                <tr>
                                                    <td>b(<?php echo $key ?>)</td>
                                                    <td><?php echo $value ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /average-b -->

                            <!-- coeficient -->
                            <div class="col-xs-6">
                                <div class="box">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Silhoutte Coeficient</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table class="table table-bordered">
                                            <?php foreach ($silhoutte_results['coeficient'] as $key => $value) : ?>
                                                <tr>
                                                    <td>s(<?php echo $key ?>)</td>
                                                    <td><?php echo $value ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /coeficient -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>