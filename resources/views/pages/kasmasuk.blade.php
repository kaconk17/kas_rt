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
                    <h3 class="box-title">Hover Data Table</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive">
                    <table id="tb_iuran" class="table table-bordered table-hover text-nowrap">
                        <thead>
                        <tr>
                        <th>Id</th>
                        <th>Nama</th>
                        <th>email</th>
                        <th>Phone</th>
                        <th>Tgl Lahir</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat Asal</th>
                        <th>Alamat Sekarang</th>
                        <th>Pekerjaan</th>
                        <th>Agama</th>
                        <th>No. KTP</th>
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
             <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="5">
             </textarea>
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
@endsection

@section('script')
<script src="{{asset('assets/select2/js/select2.full.min.js')}}"></script>
<script>
    $(function(){
        $("#nama").select2()
    });
</script>
<script type="text/javascript">
$(document).ready(function(){
    $("#form_masuk").submit(function(e){
        e.preventDefault();
        var datas = $(this).serialize();
        var btn = $("#btn-save");
        btn.html('Simpan');
        btn.attr('disabled', true);
        //alert('test');
        
    $.ajax({
        url: APP_URL+'/postmasuk',
        type: 'POST',
        dataType: 'json',
        data: datas,
    })
    .done(function(resp) {
        if (resp.success) {
	       
			//window.location.href = "{{ route('masuk')}}";
        }
        else
        $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
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