@extends('layouts.pimpinan')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">

        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="card">
              <div class="card-header">
                <h3 class="card-title">Data Pengaduan Selesai2</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="pengaduan_close" class="table table-bordered table-striped">
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
          <!-- /.row -->
          <!-- Main row -->

          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
      </section>
    <!-- /.content -->
  </div>
  <div class="modal fade" id="ajaxModelLaporan" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
            <form id="formProses" name="formProses" class="form-horizontal" enctype="multipart/form-data">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <section class="content">
                        <div class="container-fluid">
                          <div class="row">
                            <div class="col-12">
                              <div class="callout callout-info">
                                <h5><i class="fas fa-info"></i> Layanan Pengadauan Akademik Kampus</h5>
                              </div>


                              <!-- Main content -->
                              <div class="invoice p-3 mb-3">
                                <!-- title row -->
                                <div class="row">
                                  <div class="col-12">
                                    <h4>
                                      <i class="fas fa-globe"></i> <u  id="kode"></u>
                                      <small class="float-right">Date: <u id="waktu"></u> </small>
                                    </h4>
                                  </div>
                                  <!-- /.col -->
                                </div>
                                <!-- info row -->

                                <div class="row invoice-info">
                                  <div class="col-sm-4 invoice-col">
                                    <u>Laporan</u>
                                    <address>
                                      <b id="mah"></b><br>
                                      <b id="induk"></b><br>
                                      <b id="jurusan"></b><br>
                                      <b id="falkultas"></b><br>
                                      <b id="Email"></b><br>
                                    </address>
                                  </div>
                                  <!-- /.col -->
                                  <div class="col-sm-4 invoice-col">

                                  </div>
                                  <!-- /.col -->
                                  <div class="col-sm-4 invoice-col">
                                    <u>Diproses</u>
                                    <address>
                                      <b id="nm_pet"></b><br>
                                      <b id="email_pet"></b><br>


                                    </address>
                                  </div>
                                  <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- Table row -->
                                <div class="row">
                                  <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                      <thead>
                                      <tr>
                                        <th>Kode Layanan</th>
                                        <th>Jenis</th>
                                        <th>Keterangan</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                      </tr>
                                      </thead>
                                      <tbody class="data">

                                      </tbody>
                                    </table>
                                  </div>
                                  <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <div class="row">
                                  <!-- accepted payments column -->

                                  <div class="col-sm-12 text-center">
                                    <div class="text-center mt-2 pb-3"><b>--Tangapan Petugas-</b></div>
                                   <h5 id="tanggapan"></h5>
                                  </div>
                                  <!-- /.col -->
                                  <div class="col-12 mt-3">
                                      <hr>
                                    <p class="lead">Keterangan Pemprosesan</p>

                                    <div class="card-body p-0">
                                      <table class="table table-sm text-sm text-center">
                                        <thead>
                                            <tr>
                                              <th>Petugas</th>
                                              <th>Keterangan</th>
                                              <th>Waktu</th>

                                            </tr>
                                            </thead>
                                            <tbody class="log">

                                            </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <!-- /.col -->
                                </div>
                                <!-- /.row -->

                                <!-- this row will not appear when printing -->

                              </div>
                              <!-- /.invoice -->
                            </div><!-- /.col -->
                          </div><!-- /.row -->
                        </div><!-- /.container-fluid -->
                      </section>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <a href="" rel="noopener" target="_blank" class="btn btn-primary"><i class="fas fa-print"></i> Print</a>
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
       var table_pengaduan =  $('#pengaduan_close').DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
                ajax: {
                url:"{{ route('laporan-pim') }}",
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

    $('body').on('click', '.edit-detail', function () {
      var id = $(this).data('id');
        console.log(id);

        $.get("laporan-detail" +'/' + id ,
        function (data) {

                $('#updateBtn').val("Proses Pengajuan");
                $('#ajaxModelLaporan').modal('show');

                $('tbody.data').html(data.table_data);
                $('tbody.log').html(data.table_log);

                $('#kode').text(data.kode_tiket);
                $('#waktu').text(data.waktu);

                $('#mah').text(data.nama);
                $('#induk').text(data.no_induk);
                $('#falkultas').text(data.falkultas);
                $('#jurusan').text(data.jurusan);
                $('#email').text(data.email);

                $('#nm_pet').text(data.nama_pet);
                $('#email_pet').text(data.email_pet);


                $('#tanggapan').text(data.tangapan);


                $('#jenis_layanan').val(data.jenis_layanan);
                $('#keterangan').val(data.keterangan);
                $('#store_image').html("<img src={{ URL::to('/') }}/images/pengaduan/" + data.image_pengaduan + " width='500' class='img-thumbnail rounded' />");


            })

   });



    $('body').on('submit', '#formProses', function (e) {
            e.preventDefault();

      var actionType = $('#btnClosePengajuan').val();
      $('#btnClosePengajuan').html('Sending..');
      var formData = new FormData(this);
        $.ajax({
          type:'POST',
          url:  "{{ route('pengaduan-close') }}",
          data: formData,
          cache:false,
          contentType: false,
          processData: false,
          success:(data) => {

                $('#formProses').trigger("reset");
                $('#ajaxModelProses').modal('hide');
                var oTable = $('#pengaduan_proses').dataTable();
                oTable.fnDraw(false);
            },
            error: function(data){
                console.log('Error:', data);
            }
        });
    });

  </script>
@endsection
