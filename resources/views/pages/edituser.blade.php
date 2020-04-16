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
                        <button class="btn btn-warning"><i class="fa fa-warning"></i> Ganti Password</button>
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

    @endsection