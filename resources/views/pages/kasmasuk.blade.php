@extends('layout.main')

@section('content')
  <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        KAS
        <small>Kas Masuk</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Kas Masuk</li>
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
            
            <button class="btn btn-success" data-toggle="modal" data-target="#tambah_modal"><i class="fa fa-plus"></i> Tambah Kas</button>
        </div>
      </div>
      <!-- /.row -->
      <!-- Main row -->
     <div class="row">
        <div class="col-xs-12">
            <div class="box">

                    <div class="box-header">
                    <h3 class="box-title">Daftar Kas Masuk</h3>
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
                    <table id="tb_iuran" class="table table-bordered table-hover text-nowrap">
                        <thead>
                        <tr>
                        <th>Id</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Periode</th>
                        <th>Input</th>
                        <th>Keterangan</th>
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
        <h5 class="modal-title" id="exampleModalLongTitle">Kas Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="form_masuk" method="POST">
         @csrf
          <div class="row form-group">
            <div class="col col-md-3"><label>Nama : </label></div>
              <div class="col col-md-4">
                 <select name="nama" id="nama" class="form-control select2" required>
                    <option value="">---Pilih Nama----</option>
                    @foreach ($user as $y)
                    <option value="{{$y->id}}">{{$y->nama}}</option>
                    @endforeach
                </select>
              </div>
          </div>
       
          <div class="row form-group">
            <div class="col col-md-3"><label>Tanggal :</label></div>
            <div class="col col-md-4">
              <input type="date" class="form-control" name="tanggal" id="tanggal" required>
            </div>
          </div>
         
          <div class="row form-group">
            <div class="col col-md-3"><label>Jenis :</label></div>
            <div class="col col-md-4">
              <select name="jenis" id="jenis" class="form-control" required>
                <option value="">--Pilih Jenis--</option>
                <option value="iuran_ditempati">Iuran Ditemapti</option>
                <option value="iuran_tidak_ditempati">Iuran Tidak ditempati</option>
                <option value="sumbangan">Sumbangan</option>
                <option value="lain_lain">Lain-lain</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label>Jumlah :</label></div>
            <div class="col col-md-4">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i>Rp</i>
                  </div>
                  <input type="number" name="jumlah" id="jumlah" class="form-control" required>
                </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label>Periode :</label></div>
            <div class="col col-md-4">
                <input type="month" name="periode" id="periode" required>
            </div>
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label>Keterangan :</label></div>
            <div class="col col-md-6">
             <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5" placeholder="Keterangan"></textarea>
            </div>
          </div>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="btn-save">Simpan</button>
      </div>
    </div>
    </form>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Edit Masuk</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="form_edit" method="POST">
         @csrf
          <div class="row form-group">
            <div class="col col-md-3"><label>Nama : </label></div>
              <div class="col col-md-4">
              <input type="hidden" id="edit_id">
                <label id="nama_edit"></label>
              </div>
          </div>
       
          <div class="row form-group">
            <div class="col col-md-3"><label>Tanggal :</label></div>
            <div class="col col-md-4">
              <label id="tgl_edit"></label>
            </div>
          </div>
         
          <div class="row form-group">
            <div class="col col-md-3"><label>Jenis :</label></div>
            <div class="col col-md-4">
              <select name="edit_jenis" id="edit_jenis" class="form-control" required>
                <option value="">--Pilih Jenis--</option>
                <option value="iuran_ditempati">Iuran Ditemapti</option>
                <option value="iuran_tidak_ditempati">Iuran Tidak ditempati</option>
                <option value="sumbangan">Sumbangan</option>
                <option value="lain_lain">Lain-lain</option>
              </select>
            </div>
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label>Jumlah :</label></div>
            <div class="col col-md-4">
                <div class="input-group">
                  <div class="input-group-addon">
                    <i>Rp</i>
                  </div>
                  <input type="number" name="edit_jumlah" id="edit_jumlah" class="form-control" required>
                </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label>Periode :</label></div>
            <div class="col col-md-4">
               <label id="edit_periode"></label>
            </div>
          </div>
          <div class="row form-group">
            <div class="col col-md-3"><label>Keterangan :</label></div>
            <div class="col col-md-6">
             <textarea class="form-control" name="edit_keterangan" id="edit_keterangan" cols="30" rows="5" placeholder="Keterangan"></textarea>
            </div>
          </div>
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" id="btn-update">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>
@endsection

@section('script')
<script src="{{asset('assets/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<script>
    $(function(){
        $("#nama").select2()
    });
</script>
<script type="text/javascript">
$(document).ready(function(){
    var key = localStorage.getItem('user_token');
    var awal = $("#tgl-awal").val();
    var akhir = $("#tgl-akhir").val();

    var tb_masuk =   $('#tb_iuran').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        responsive: true,
        ordering: false,
        ajax: {
                        url: APP_URL+'/api/listiuran',
                        type: "POST",
                        headers: { "token_req": key },
                        data: function(d){
                            d.tgl_awal = $("#tgl-awal").val();
                            d.tgl_akhir = $("#tgl-akhir").val();
                        }
                        
                    },
        columnDefs:[
            {
                targets: [ 0, 8],
                visible: false,
                searchable: false
            },
            {
              targets: [9],
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
            { data: 'id_masuk', name: 'id_masuk' },
            { data: 'tgl_bayar', name: 'tgl_bayar' },
            { data: 'nama', name: 'nama' },
            { data: 'jenis', name: 'jenis' },
            { data: 'jumlah', name: 'jumlah' },
            { data: 'periode', name: 'periode' },
            { data: 'nama_input', name: 'nama_input' },
            { data: 'keterangan', name: 'keterangan' },
            { data: 'tgl_closing', name: 'tgl_closing' },
        ]
    });

    $("#btn-reload").click(function(){
        var date1 = $("#tgl-awal").val();
        var date2 = $("#tgl-akhir").val();
        tb_masuk.ajax.reload();
    });

    $("#tb_iuran").on('click','.btn-danger',function(){
      var data = tb_masuk.row( $(this).parents('tr') ).data();
      var t = confirm("Apakah anda akan menghapus iuran dari "+data.nama+" ?");
      if (t) {
        var d = {"id":data.id_masuk};
        action_data(APP_URL+"/api/masuk/delete",d,key).done(function(resp){
          if (resp.success) {
            alert(resp.message);
            window.location.href = "{{ route('masuk')}}";
          }else{
            alert(resp.message);
          }
        }).fail(function(){

        });
      }
    });

    $("#tb_iuran").on('click','.btn-success',function(){
      var data = tb_masuk.row( $(this).parents('tr') ).data();
      $("#nama_edit").html(data.nama);
      $("#edit_id").val(data.id_masuk)
      $("#tgl_edit").html(data.tgl_bayar);
      $("#edit_jumlah").val(data.jumlah);
      $("#edit_periode").html(data.periode);
      $("#edit_keterangan").html(data.keterangan);
      $("#edit_jenis").val(data.jenis);
      $("#edit_modal").modal("show");
    });

    $("#form_masuk").submit(function(e){
        
        e.preventDefault();
        var datas = $(this).serialize();
        var btn = $("#btn-save");
        btn.html('Simpan');
        btn.attr('disabled', true);
       
        
    $.ajax({
        url: APP_URL+'/kas/postmasuk',
        type: 'POST',
        dataType: 'json',
        data: datas,
    })
    .done(function(resp) {
        if (resp.success) {
	       alert(resp.message);
			window.location.href = "{{ route('masuk')}}";
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

$("#form_edit").submit(function(e){
  e.preventDefault();
  
  
  var d = $(this).serialize();
  var btn = $("#btn-update");
  var _key = localStorage.getItem('user_token');
  btn.html('Update');
  btn.attr('disabled', true);
  action_data(APP_URL+"/masuk/edit", d, _key).done(function(resp){
          if (resp.success) {
            alert(resp.message);
          
          }else{
            alert(resp.message);
          }
        }).fail(function(){

        });
        
});

function action_data(link_url, datas, key){
  return $.ajax({
        url: link_url,
        type: 'POST',
        dataType: 'json',
        headers : { "token_req": key },
        data: datas,
    });
}
</script>
@endsection