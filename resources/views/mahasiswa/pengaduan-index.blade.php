@extends('layouts.mahasiswa')

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
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Condensed Full Width Table</h3>
              <div class="float-sm-right">
                  <a href="{{ route('pengaduan-create') }}" class="btn btn-sm btn-primary">Buat Laporan</a>
            </div>
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
        <!-- /.row -->
        <!-- Main row -->

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

@endsection
