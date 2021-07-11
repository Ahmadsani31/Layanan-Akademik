@extends('layouts.admin')

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
                <h3 class="card-title">Data Pengaduan Yang Sedang Diproses</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="pengaduan_proses" class="table table-bordered table-striped">
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
  <div class="modal fade" id="ajaxModelProses" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
            <form id="formProses" name="formProses" class="form-horizontal" enctype="multipart/form-data">
				<div class="modal-header">
					<h4 class="modal-title" id="modelHeading"></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"> <span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
                    <input type="hidden" name="id_pengajuan" id="id_pengajuan">
                    <input type="hidden" name="id_mahasiswa" id="id_mahasiswa">
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
                      <hr>
                      <div class="text-center mt-2 pb-3"><b>--TERIMA KASIH--</b></div>
                      <div class="form-group row">
                        <label for="inputEmail3" class="col-sm-2 col-form-label">Keterangan</label>
                        <div class="col-sm-10">
                          <textarea name="ket" class="form-control" id="" cols="20" rows="5" required></textarea>
                        </div>
                      </div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" id="btnClosePengajuan" class="btn btn-warning" value="create">CLOSE PENGAJUAN</button>
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
       var table_pengaduan =  $('#pengaduan_proses').DataTable({
            processing: true,
            serverSide: true,
            "responsive": true,
                ajax: {
                url:"{{ route('dashboard-proses') }}",
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

    $('body').on('click', '.edit-proses', function () {
      var id = $(this).data('id');
        console.log(id);

        $.get("pengaduan-show" +'/' + id ,
        function (data) {

            $('#modelHeading').html("Data Pengajuan Diproses");
                $('#updateBtn').val("Proses Pengajuan");
                $('#ajaxModelProses').modal('show');

                $('#id_pengajuan').val(data.id);
                $('#id_mahasiswa').val(data.mahasiswa_id);
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
