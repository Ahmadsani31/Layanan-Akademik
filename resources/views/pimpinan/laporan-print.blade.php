<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Invoice Print</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
</head>
<body>
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
      <div class="container">
    <!-- title row -->
    <div class="row m-5">
      <div class="col-12">
        <h2 class="page-header">
          <i class="fas fa-globe"></i> {{ $peng->kode_tiket }}.
          <small class="float-right">Date: {{ $peng->created_at->format('d-m-Y') }}</small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-4 invoice-col">
        Laporan
        <address>
          <strong>{{ $mah->name }}</strong><br>
          {{ $mah->no_induk }}<br>
          {{ $mah->jurusan }}<br>
          {{ $mah->falkultas }}<br>
          {{ $mah->email }}<br>
        </address>
      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">

      </div>
      <!-- /.col -->
      <div class="col-sm-4 invoice-col">
        Proses
        <address>
          <strong>{{ $pet->name }}</strong><br>
          <strong>{{ $pet->email }}</strong><br>
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
          @foreach ($p as $item)

          <tbody>
          <tr>
            <td>{{ $item->kode_tiket }}</td>
            <td>{{ $item->jenis_layanan }}</td>
            <td>{{ $item->keterangan }}</td>
            <td><img src="{{ asset('images/pengaduan/'.$item->image_pengaduan) }}" alt="" width="100"> </td>
            <td><span class="badge bg-success">{{ $item->status }}</span></td>

          </tr>

          </tbody>
          @endforeach

        </table>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->

    <div class="row">
      <!-- accepted payments column -->
      <div class="col-sm-12 text-center">
        <div class="text-center mt-2 pb-3"><b>--Tangapan Petugas-</b></div>
       <h5>{{ $tg->keterangan }}</h5>
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
              @foreach ($log as $l)

              <tbody>
                <td>{{ $l->petugas->name }}</td>
                <td>{{ $l->keterangan }}</td>
                <td>{{ $l->created_at->format('D, d-M-y H:i') }}</td>
              </tbody>
              @endforeach

        </table>
      </div>
    </div>
      <!-- /.col -->
    </div>
</div>
    <!-- /.row -->
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
<!-- Page specific script -->
<script>
  window.addEventListener("load", window.print());
</script>
</body>
</html>
