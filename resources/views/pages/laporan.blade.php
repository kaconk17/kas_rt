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
        <div class="box box-primary">
            <div class="col col-md-3">

            </div>
            <div class="box-body col-md-6">
                <canvas id="graph"></canvas>
            </div>
        </div>
      </div>
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
            <button type="button" class="btn btn-success" id="btn_simpan">Simpan Laporan</button>
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
    <div class="modal fade" id="simpan_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Simpan Laporan</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="row form-group">
                    <div class="col col-md-3"><label>Periode :</label></div>
                    <div class="col col-md-4">
                        <input type="month" name="periode" id="periode" required>
                    </div>
                  </div>
           </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary" id="simpan_laporan">Simpan</button>
            </div>
          </div>
        
        </div>
      </div>

@endsection

@section('script')
<script src="{{asset('assets/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script src="{{asset('assets/chartjs/Chart.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var key = localStorage.getItem('user_token');
        var tb_trans =   $('#tb_laporan').DataTable({
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
        var ctx = document.getElementById('graph').getContext('2d');
        var chart = new Chart(ctx, {
            // The type of chart we want to create
            type: 'bar',

            // The data for our dataset
            data: {
                
            },

            // Configuration options go here
            options: {}
        });

        tampil_chart($("#tgl-awal").val(),$("#tgl-akhir").val(),chart,key);
        $("#btn-reload").click(function(){
            var date1 = $("#tgl-awal").val();
            var date2 = $("#tgl-akhir").val();
            tb_trans.ajax.reload();
            tampil_chart(date1,date2,chart,key);
        });
        var tb_lapor =   $('#tb_bulanan').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            responsive: true,
            ordering: false,
            ajax: {
                            url: APP_URL+'/api/listbulanan',
                            type: "POST",
                            headers: { "X-API-Key": key },
                        },
            columnDefs:[
                {
                    targets: [ 0],
                    visible: false,
                    searchable: false
                },
                
            ],
        
            columns: [
                { data: 'id_laporan', name: 'id_laporan' },
                { data: 'tgl_laporan', name: 'tgl_laporan' },
                { data: 'periode', name: 'periode' },
                { data: 'saldo_awal', name: 'saldo_awal',render: $.fn.dataTable.render.number(',', '.', 2, 'Rp')},
                { data: 'total_masuk', name: 'total_masuk',render: $.fn.dataTable.render.number(',', '.', 2, 'Rp')},
                { data: 'total_keluar', name: 'total_keluar',render: $.fn.dataTable.render.number(',', '.', 2, 'Rp')},
                { data: 'saldo_akhir', name: 'saldo_akhir',render: $.fn.dataTable.render.number(',', '.', 2, 'Rp')},
                { data: 'keterangan', name: 'keterangan' },
            ]
        });

        $("#btn_simpan").click(function(){
           $("#simpan_modal").modal('show');
        });
        $("#simpan_laporan").click(function(){
            var r = confirm("Apakah anda akan closing bulanan ?");
            var date1 = $("#periode").val();
            var d = {"periode":date1};
            if(r){
                action_data(APP_URL+"/api/laporan/save", d, key).done(function(resp){
                if (resp.success) {
                    alert(resp.message);
                    window.location.href = "{{ route('laporan')}}";
                }else{
                    alert(resp.message);
                }
                }).fail(function(){

                });
            }
        });
    });
function tampil_chart(awal, akhir, chart, key){
    $.ajax({
            url: APP_URL + "/api/grafikreport",
            method: "POST",
            data: { "tgl_awal": awal, "tgl_akhir": akhir },
            dataType: "json",
            headers: { "X-API-Key": key },
            success: function (data) {
                var label = [];
                var value = [];

                    label.push('Awal');
                    value.push(data.awal);
                    label.push('Kas Masuk');
                    value.push(data.in);
                    label.push('Kas Keluar');
                    value.push(data.out);
                    label.push('Saldo Akhir');
                    value.push(data.end);
        
                chart.data = {
                    labels: label,
                    datasets: [
                       
                        {
                            label: 'Kas',
                            //backgroundColor: 'rgb(51, 153, 255)',
                            backgroundColor: ['blue','green','red','blue'],
                            borderColor: 'rgb(51, 153, 255)',
                            data: value,
                        }

                    ]
                };
                chart.options = {

                
                };
                chart.update();
            }

        });


}
function action_data(link_url, datas, key){
  return $.ajax({
        url: link_url,
        type: 'POST',
        dataType: 'json',
        headers: { "X-API-Key": key },
        data: datas,
    });
}
</script>
@endsection