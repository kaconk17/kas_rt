@extends('layout.main')

@section('content')
  <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        KAS
        <small>Laporan Kas</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Laporan Kas</li>
      </ol>
</section>

    <!-- Main content -->
    <section class="content">
    @if(Session::has('alert-success'))
    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-check"></i> Success!</h4>
            {{Session::get('alert-success')}}
        </div>
      @elseif(Session::has('alert-danger'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
            {{Session::get('alert-danger')}}
        </div>
    @endif
      <!-- Small boxes (Stat box) -->
      <div class="row">
       <div class="box box-success">
        <div class="box-header">
            <h3>Laporan Kas</h3>
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="tgl-awal" class="col-sm-2 control-label">Perode :</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="tgl-awal" id="tgl-awal" value="{{date('Y-m').'-01'}}">
                    </div>
                    <label for="tgl-akhir" class="col-sm-2 control-label">Sampai</label>
                    <div class="col-sm-3">
                        <input type="date" class="form-control" name="tgl-akhir" id="tgl-akhir" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="col-sm-2">
                    <button type="button" class="btn btn-primary" id="btn-reload"><i class="fa fa-refresh"></i> Reload</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="box-body">
            <table id="tb_laporan" class="table table-bordered table-hover text-nowrap">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Tanggal</th>
                        <th>Jenis Transaksi</th>
                        <th>Jumlah</th>
                        <th>Keterangan</th>
                        <th>Periode</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <button type="button" class="btn btn-success">Simpan Laporan</button>
        </div>
       </div>
      </div>
      <div class="row">
        <div class="box box-warning">
            <div class="box-header">
                <h3>Laporan Bulanan</h3>
            </div>
            <div class="box-body">
                <table id="tb_bulanan" class="table table-bordered table-hover text-nowrap">
                    <thead>
                        <tr>
                            <th>ID Laporan</th>
                            <th>Tanggal Laporan</th>
                            <th>Periode</th>
                            <th>Saldo Awal</th>
                            <th>Total Masuk</th>
                            <th>Total Keluar</th>
                            <th>Saldo Akhir</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
      </div>
    </section>
    <!-- /.content -->

@endsection

@section('script')
<script src="{{asset('assets/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var key = localStorage.getItem('user_token');
        var tb_lapor =   $('#tb_laporan').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            responsive: true,
            ordering: false,
            ajax: {
                            url: APP_URL+'/api/listtrans',
                            type: "POST",
                            headers: { "X-API-Key": key },
                            data: function(d){
                                d.tgl_awal = $("#tgl-awal").val();
                                d.tgl_akhir = $("#tgl-akhir").val();
                            }
                            
                        },
            columnDefs:[
                {
                    targets: [ 0],
                    visible: false,
                    searchable: false
                },
                
            ],
        
            columns: [
                { data: 'id_record', name: 'id_record' },
                { data: 'tgl_transaksi', name: 'tgl_transaksi' },
                { data: 'jenis', name: 'jenis' },
                { data: 'jumlah', name: 'jumlah',render: $.fn.dataTable.render.number(',', '.', 2, 'Rp')},
                { data: 'keterangan', name: 'keterangan' },
                { data: 'periode', name: 'periode' },
            ]
        });

        $("#btn-reload").click(function(){
            var date1 = $("#tgl-awal").val();
            var date2 = $("#tgl-akhir").val();
            tb_lapor.ajax.reload();
        });
    });
</script>
@endsection