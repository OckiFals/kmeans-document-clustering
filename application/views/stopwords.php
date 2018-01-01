 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Tabel StopWords
        <small>Bahasa Indonesia by Tala</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="forminput"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Analisa</a></li>
        <li class="active">StopWords</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          
          <!-- /.box -->

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Daftar StopWords</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">No</th>
                  <th>Daftar Stopwords</th>
                 
                </tr>

                <?php
                $no = 1;
                 foreach ($query as $row){
                ?>

                <tr>
                  <td><?php echo $no++ ?></td>
                  <td><?php echo $row->stopword ?></td> 
                 
                </tr>

                  <?php  } ?> 


               
              </table>
            </div>

            
            <!-- /.box-body -->
            <div class="box-footer clearfix">

              <a href="editStopword"><button type="" class="btn btn-info pull-left"> Edit</button></a>
             
            
              <ul class="pagination pagination-sm no-margin pull-right">
                <li><a href="#">&laquo;</a></li>
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">&raquo;</a></li>
              </ul>
            </div>
          </div>

        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>