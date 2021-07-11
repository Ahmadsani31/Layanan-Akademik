@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-4 col-sm-6 col-12">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ $total }}</h3>

                <p>JUMLAH PENGADUAN</p>
              </div>
              <div class="icon">
                <i class="fas fa-sort-amount-up-alt"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-sm-6 col-12">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ $proses }}</h3>

                <p>PENGADUAN DIPROSES</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-sm-6 col-12">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ $close }}</h3>

                <p>PENGADUAN CLOSE</p>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Condensed Full Width Table</h3>

            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="pengaduan" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode Layanan</th>
                      <th>Jenis</th>
                      <th>Nama</th>
                      <th>Keterangan</th>
                      <th>Status</th>
                      <th>Image</th>
                      <th>Waktu</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                  </table>
            </div>
            <!-- /.card-body -->
          </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="ajaxModelView" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form id="dataFormType" name="dataFormType" class="form-horizontal">
				<div class="modal-header">
					<h4 class="modal-title" id="modelHeading"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <input type="hidden" id="id_pengajuan">
                    <input type="hidden" id="id_mahasiswa">
                    <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Jenis Pengaduan</label>
                        <div class="col-sm-10">
                          <select class="form-control" id="jenis_layanan" name="jenis_layanan" disabled>
                            <option disabled selected>Chosee One</option>
                            <option value="akademik">Akademik</option>
                            <option value="keuangan">Keuangan</option>
                          </select>
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                          <textarea name="keterangan" id="keterangan" class="form-control" id="" cols="20" rows="5" readonly></textarea>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label for="inputPassword3" class="col-sm-2 col-form-label">Image</label>
                        <div class="col-sm-10">
                            <div id="store_image"></div>

                        </div>
                      </div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" id="btnProsesPengajuan" class="btn btn-success" value="create">PROSES PENGAJUAN</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script src="{{ asset('assets/js/jquery-3.6.0.js') }}"></script>
<script src="{{ asset('assets/js/jquery.validate.min-1.19.2.js') }}" ></script>

<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
              headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
        });
    });

    $(document).ready(function(){
       var table_pengaduan =  $('#pengaduan').DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
                ajax: {
                url:"{{ route('dashboard-pet') }}",
                type: 'GET',
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'kode', name: 'kode'},
                    {data: 'layanan', name: 'layanan'},
                    {data: 'mahasiswa', name: 'mahasiswa'},

                    {data: 'keterangan', name: 'keterangan'},
                    {data: 'status', name: 'status'},
                    {data: 'image', name: 'image',render:function(data, type, full, meta)
                        {
                        return "<img src=/images/pengaduan/" + data +" width='100' class='img-thumbnail' />";
                        },orderable: false
                    },
                    {data: 'waktu', name: 'waktu'},

                    {data: 'action', name: 'action', orderable: false, searchable: false},
                    ],
                order: [[0, 'desc']]
        });
    });

    $('body').on('click', '.edit-product', function () {
      var id = $(this).data('id');
        console.log(id);

        $.get("pengaduan-show" +'/' + id ,
        function (data) {

                $('#modelHeading').html("Show Data Pengajuan");
                $('#updateBtn').val("Proses Pengajuan");
                $('#ajaxModelView').modal('show');

                $('#id_pengajuan').val(data.id);
                $('#id_mahasiswa').val(data.mahasiswa_id);
                $('#jenis_layanan').val(data.jenis_layanan);
                $('#keterangan').val(data.keterangan);
                $('#store_image').html("<img src={{ URL::to('/') }}/images/pengaduan/" + data.image_pengaduan + " width='500' class='img-thumbnail rounded' />");

                $('#pengaduan').DataTable().ajax.reload();

            })
   });

   $('body').on('click', '#btnProsesPengajuan', function () {
    var id_pengajuan = $("#id_pengajuan").val();

        $.ajax({
            type:'GET',
            url:  "pengaduan-proses"+'/'+ id_pengajuan,
            success: function (data) {
              var oTable = $('#pengaduan').dataTable();
              $('#pengaduan').DataTable().ajax.reload();
              oTable.fnDraw(false);
              $('#ajaxModelView').modal('hide');

              },
              error: function (data) {
                  console.log('Error:', data);
              }
        });
    });
  </script>
@endsection
