@extends('layout.main')

@section('content')
  <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        KAS
        <small>Kas Keluar</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kas Keluar</li>
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
        <div class="col-xs-12">
            
            <button class="btn btn-danger" id="btn_tmbh"><i class="fa fa-plus"></i> Tambah Pengeluaran</button>
            
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
     <div class="row">
        <div class="col-xs-12">
            <div class="box">
                    <div class="box-header">
                    <h3 class="box-title">Daftar Pengeluaran Kas</h3>
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
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                        <table id="tb_keluar" class="table table-bordered table-hover text-nowrap">
                            <thead>
                            <tr>
                            <th>Id</th>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Periode</th>
                            <th>Closing</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- /.box-body -->
            </div>
        </div>
     </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
<!-- Modal -->
<div class="modal fade" id="tambah_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Pengeluaran Kas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" id="form_tambah">
              @csrf
              <div class="form-group row">
                <label for="edit-nama" class="col-md-4 col-form-label text-md-right">Saldo</label>

                <div class="col-md-6">
                   
                <label>Rp {{number_format($saldo)}}</label>

                </div>
            </div>
              <div class="form-group row">
                  <label for="edit-nama" class="col-md-4 col-form-label text-md-right">Tanggal</label>

                  <div class="col-md-6">
                     
                      <input id="tanggal" type="date" class="form-control" name="tanggal" required>

                      @error('edit-nama')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                      @enderror
                  </div>
              </div>
              <div class="form-group row">
                  <label for="harga" class="col-md-4 col-form-label text-md-right">{{ __('Jumlah') }}</label>

                  <div class="col-md-6">
                    <div class="input-group">
                        <div class="input-group-addon">
                          <i>Rp</i>
                        </div>
                        <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                      </div>

                      @error('harga')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="form-group row">
                <label for="harga" class="col-md-4 col-form-label text-md-right">{{ __('Periode') }}</label>

                <div class="col-md-6">
                    <input type="month" name="periode" class="form-control" id="periode" required>

                    @error('harga')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

              <div class="form-group row">
                  <label for="desk" class="col-md-4 col-form-label text-md-right">{{ __('Deskripsi') }}</label>

                  <div class="col-md-6">
                  <textarea name="desk" id="desk" cols="30" rows="10" class="form-control @error('desk') is-invalid @enderror" name="desk" value="{{ old('desk') }}" required></textarea>
                      

                      @error('desk')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script type="text/javascript">
$(document).ready(function(){
    var key = localStorage.getItem('user_token');
    var tb_keluar =   $('#tb_keluar').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                        url: APP_URL+'/api/listkeluar',
                        type: "POST",
                        headers: { "X-API-Key": key },
                        data: function(d){
                            d.tgl_awal = $("#tgl-awal").val();
                            d.tgl_akhir = $("#tgl-akhir").val();
                        }
                        
                    },
        columnDefs:[
            {
                targets: [ 0, 6],
                visible: false,
                searchable: false
            },
            {
              targets: [7],
              data: null,
              //defaultContent: "<button class='btn btn-success'><i class='fa fa-edit'></i></button><button class='btn btn-danger'><i class='fa fa-trash'></i></button>"
              render: function(data , type, row, meta){
                                  if (data.tgl_closing != null){
                                    return "";
                                  }else{
                                    return "<button class='btn btn-success'><i class='fa fa-edit'></i></button><button class='btn btn-danger'><i class='fa fa-trash'></i></button>";

                                  }
                                }
            }
        ],
       
        columns: [
            { data: 'id_keluar', name: 'id_keluar' },
            { data: 'tgl_keluar', name: 'tgl_keluar' },
            { data: 'nama', name: 'nama' },
            { data: 'jumlah', name: 'jumlah' },
            { data: 'keterangan', name: 'keterangan' },
            { data: 'periode', name: 'periode' },
            { data: 'tgl_closing', name: 'tgl_closing' },
        ]
    });

    $("#btn_tmbh").click(function(){
        $("#tambah_modal").modal("show");
    });

    $("#form_tambah").submit(function(e){
        e.preventDefault();
        var datas = $(this).serialize();
        var btn = $("#btn-save");
        btn.html('Simpan');
        btn.attr('disabled', true);

        $.ajax({
        url: APP_URL+'/kas/postkeluar',
        type: 'POST',
        dataType: 'json',
        data: datas,
            })
            .done(function(resp) {
                if (resp.success) {
                //alert(resp.message);
                    window.location.href = "{{ route('keluar')}}";
                }
                else
                alert(resp.message);
                //$("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
            })
            .fail(function() {
                $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
                //toastr['warning']('Tidak dapat terhubung ke server !!!');
            })
            .always(function() {
                btn.html('Simpan');
                btn.attr('disabled', false);
            });
            
            return false;
           
    });

});
</script>
@endsection