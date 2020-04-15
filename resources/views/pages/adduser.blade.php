@extends('layout.main')

@section('content')
  <!-- Content Header (Page header) -->
<section class="content-header">
      <h1>
        Users
        <small>User Management</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User</li>
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
              <h3 class="box-title">Tambah User</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" method="POST" action="{{ url('/postreg') }}">
                @csrf
              <div class="box-body">
                <div class="row">
                      <div class="form-group col col-md-4">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama" value="{{ old('nama') }}" required>
                        @error('nama')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>

                  </div>
                  <div class="row">

                      <div class="form-group col col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="form-group col col-md-4">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        @error('password')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>

                  </div>

                
                  <div class="row">
                      <div class="form-group col col-md-4">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" placeholder="Nomer Telepon" value="{{ old('telepon') }}" required>
                        @error('telepon')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="form-group col col-md-4">
                        <label for="ktp">No. KTP</label>
                        <input type="text" class="form-control" id="ktp" name="ktp" placeholder="Nomer KTP" value="{{ old('ktp') }}" required>
                        @error('ktp')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-group col col-md-4">
                        <label for="tgl_lahir">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir" value="{{ old('tgl_lahir') }}" required>
                        @error('tgl_lahir')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                      <div class="form-group col col-md-3">
                        <label for="kelamin">Jenis Kelamin</label>
                        <select name="kelamin" id="kelamin" class="form-control" required>
                            <option value="">---Pilih Jenis Kelamin---</option>
                            <option value="L">Laki-Laki</option>
                            <option value="P">Perempuan</option>
                        </select>
                      </div>
                  </div>
                  <div class="row">
                      <div class="form-group col col-md-4">
                          <label for="alamat_asal">Alamat Asal</label>
                          <textarea class="form-control" name="alamat_asal" id="alamat_asal" cols="30" rows="5">{{ old('alamat_asal') }}</textarea>
                          @error('alamat_asal')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                        @enderror
                        </div>
                        <div class="form-group col col-md-4">
                            <label for="alamat_sekarang">Alamat Sekarang</label>
                            <textarea class="form-control" name="alamat_sekarang" id="alamat_sekarang" cols="30" rows="5">{{ old('alamat_sekarang') }}</textarea>
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
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" placeholder="Pekerjaan" value="{{ old('pekerjaan') }}">
                      </div>
                      <div class="form-group col col-md-3">
                        <label for="agama">Agama</label>
                        <select name="agama" id="agama" class="form-control">
                            <option value="">---Pilih Agama---</option>
                            <option value="islam">Islam</option>
                            <option value="kristen">Kristen</option>
                            <option value="katolik">Katolik</option>
                            <option value="hindu">Hindu</option>
                            <option value="budha">Budha</option>
                            <option value="lain-lain">Lain-Lain</option>
                        </select>
                      </div>
                  </div>
                  <div class="row">
                    <div class="form-group col col-md-3">
                        <label for="level">Level User</label>
                        <select name="level" id="level" class="form-control" required>
                            <option value="user">User</option>
                            <option value="pengurus">Pengurus</option>
                            <option value="admin">Admin</option>
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