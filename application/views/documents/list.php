<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Tabel Data Skripsi
            <small>Universitas Brawijaya</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="forminput"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Skripsi</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Daftar Skripsi</h3>
                        <div class="box-tools">
                            <div class="input-group input-group-sm" style="width: 150px;">
                                <a href="<?php echo base_url('main/add') ?>" class="btn btn-info btn-sm btn-flat pull-right">
                                    Tambahkan Data
                                </a>
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
                                <th style="width: 80px">Action</th>
                            </tr>

                            <?php foreach ($documents as $index => $row) : ?>
                                <tr>
                                    <td><?php echo $index+1 ?></td>
                                    <td><?php echo $row->judul ?></td>
                                    <td><span class="badge bg-primary"><?php echo $row->tahun ?></span></td>
                                    <td><?php echo $row->fakultas ?></td>
                                    <td>
										<div class="" align="left">
                                            <a href="<?php echo base_url('main/edit/' . $row->id) ?>">
                                                <button class="btn btn-flat btn-sm btn-primary">
                                                    <i class="glyphicon glyphicon-edit"></i>
                                                </button>
                                            </a>
											<a href="#" data-object-id="<?php echo $row->id ?>"
												data-object-name="<?php echo $row->judul ?>"
												data-toggle="modal" data-href="<?php echo base_url('main/delete/' . $row->id) ?>"
												data-target="#confirm-delete">
												<button class="btn btn-flat btn-sm btn-danger">
                                                    <i class="glyphicon glyphicon-trash"></i>
                                                </button>
											 </a> 
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
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

<!-- delete modal -->
<?php $this->load->view('delete-modal') ?>
<!-- /delete modal -->

<script type="application/javascript">
	$(document).ready(function () {
		var confirm_modal = $('#confirm-delete');
		var btn_target;

		confirm_modal.on('show.bs.modal', function (e) {
			var button = $(e.relatedTarget); // Button that triggered the modal
			var id = button.data('object-id'); // Extract post id from data-name attribute
			var title = button.data('object-name'); // Extract post id from data-name attribute
			btn_target = button;
			var modal = $(this);
			modal.find('#type-modal').text('Dokumen Skripsi');
			modal.find('#object-id').text(id);
			modal.find('#object-name').text(title);
			$(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
		});
	});
</script>
