@extends('layout.main')

@section('content')
  <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Edit User
        <small>User Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Edit User</li>
      </ol>
</section>
<!-- Main content -->
<section class="content">
    
      <!-- Small boxes (Stat box) -->
      <div class="row">
     
      </div>
      <!-- /.row -->
      <!-- Main row -->
     <div class="row">
        <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Edit User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ url('/postedit') }}">
                @csrf
              <div class="box-body">
                <div class="row">
                      <div class="form-group col col-md-2">
                        <label for="nama">Nama</label>
                       <input type="hidden" name="id" id="id" value="{{$user->id}}">
                      </div>
                      <div class="col col-md-4">
                      
                        <label>{{$user->nama}}</label>
                      </div>

                  </div>
                  <div class="row">

                      <div class="form-group col col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{$user->email}}" required>
                      </div>
                      <div class="form-group col col-md-4">
                        <label for="exampleInputPassword1">Password</label> <br>
                        <button type="button" class="btn btn-warning" id="btn-password"><i class="fa fa-warning"></i> Reset Password</button>
                      </div>

                  </div>

                
                  <div class="row">
                      <div class="form-group col col-md-4">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Nomer Telepon" value="{{$user->phone}}" required>
                        
                      </div>
                      <div class="form-group col col-md-4">
                        <label for="ktp">No. KTP</label>
                        <input type="text" class="form-control" id="ktp" name="ktp" placeholder="Nomer KTP" value="{{ $user->no_ktp }}" required>
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-group col col-md-3">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="text" class="form-control" value="{{$user->tgl_lahir}}" disabled>
                        
                       
                      </div>
                      <div class="form-group col col-md-3">
                        <label for="kelamin">Jenis Kelamin</label>
                       <input type="text" class="form-control" value="{{$user->jenis_kelamin}}" disabled>
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-group col col-md-4">
                          <label for="alamat_asal">Alamat Asal</label>
                          <textarea class="form-control" name="alamat_asal" id="alamat_asal" cols="30" rows="5">{{ $user->alamat_asal }}</textarea>
                          @error('alamat_asal')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group col col-md-4">
                            <label for="alamat_sekarang">Alamat Sekarang</label>
                            <textarea class="form-control" name="alamat_sekarang" id="alamat_sekarang" cols="30" rows="5">{{ $user->alamat_sekarang }}</textarea>
                            @error('alamat_sekarang')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>

                  </div>
                  <div class="row">
                      <div class="form-group col col-md-4">
                        <label for="pekerjaan">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan" value="{{ $user->pekerjaan}}">
                      </div>
                      <div class="form-group col col-md-3">
                        <label for="agama">Agama</label>
                       <input type="text" class="form-control" value="{{$user->agama}}" disabled>
                      </div>
                  </div>
                  <div class="row">
                    <div class="form-group col col-md-3">
                        <label for="level">Level User</label>
                        <select name="level" id="level" class="form-control" required>
                        @foreach ($level as $l)
                            <option value="{{$l->key}}" {{( $l->key == $user->level) ? 'selected' : ''}}>{{$l->value}}</option>
                        @endforeach
                        </select>
                      </div>
                  </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                      <button type="submit" class="btn btn-primary">Submit</button>
                <div class="pull-right">
                    <a href="{{url('/user')}}" class="btn btn-default">Cancel</a>
                    
                </div>
                 
              </div>
            </form>
          </div>
        </div>
     </div>
      <!-- /.row (main row) -->

    </section>
    <!-- /.content -->

    <!-- Modal -->
<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Reset Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form action="{{url('/user/passupdate')}}" method="POST" id="form-password">
        @csrf
          <div class="row">
            <div class="col col-md-3"><label>Password Baru :</label></div>
            <div class="col col-md-4">
             <input type="password" name="edit-pass" id="edit-pass" required>
          <input type="hidden" id="edit-id" name="edit-id" value="{{$user->id}}">
            </div>
          </div>
          
     </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" id="btn-update">Update</button>
      </div>
    </div>
    </form>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
$(document).ready(function(){
  $("#btn-password").click(function(){
    $("#edit-modal").modal("show");
  });

  $("#form-password").submit(function(e){
    e.preventDefault();
    var n = $("#edit-pass").val();
    var data = $(this).serialize();
    if (n.length >= 6) {
      $.ajax({
            type: "POST",
            url: APP_URL+"/user/passupdate",
            data:data,
            dataType: "json",
        })
        .done(function(resp) {
               if (resp.success) {
                alert(resp.message);
                location.reload();
               }
               else
               alert(resp.message);
               
           })
           .fail(function() {
               $("#error").html("<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>");
            
           });
    }else{
      alert("Panjang Password Min : 6 Char !");
    }
  });
});
</script>
@endsection