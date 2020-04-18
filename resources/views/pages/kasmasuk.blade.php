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
        <h5 class="modal-title" id="exampleModalCenterTitle">Edit User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form method="POST" action="{{ url('/postkredit') }}">
              @csrf

              <div class="form-group row">
                  <label for="edit-nama" class="col-md-4 col-form-label text-md-right">Nama</label>

                  <div class="col-md-6">
                      <input type="hidden" id="id-edit" name="id-edit">
                      <input id="edit-nama" type="text" class="form-control" name="edit-nama" value="{{ old('edit-nama') }}" required>

                      @error('edit-nama')
                            <span class="help-block" role="alert">
                                <strong class="text-red">{{ $message }}</strong>
                            </span>
                      @enderror
                  </div>
              </div>
              <div class="form-group row">
                  <label for="harga" class="col-md-4 col-form-label text-md-right">{{ __('Harga') }}</label>

                  <div class="col-md-6">
                      <input id="harga" type="number" class="form-control @error('harga') is-invalid @enderror" name="harga" value="{{ old('harga') }}" required autocomplete="harga" autofocus>

                      @error('harga')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>

              <div class="form-group row">
                  <label for="bunga" class="col-md-4 col-form-label text-md-right">{{ __('Bunga Kredit') }}</label>

                  <div class="col-md-3">
                   
                      <input id="bunga" type="number" class="form-control @error('bunga') is-invalid @enderror" name="bunga" value="{{ old('bunga') }}" required autocomplete="bunga" autofocus>
                   
                      @error('bunga')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
                  <label for="">%</label>
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

              <div class="form-group row">
                  <label for="desk" class="col-md-4 col-form-label text-md-right">{{ __('Gambar') }}</label>

                  <div class="col-md-6">
                  <input type="file" name="gambar" >
                      

                      @error('desk')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                  </div>
              </div>
              
              <div class="form-group row">
                  <label for="public" class="col-md-4 col-form-label text-md-right">{{ __('Post') }}</label>

                  <div class="col-md-6">
                    <div class="form-check form-check-inline">
                        <input type="hidden" name= "public" value="FALSE">
                        <input class="form-check-input @error('public') is-invalid @enderror" type="checkbox" name="public" id="public" value="TRUE">
                        <label class="form-check-label" for="laki">Set Public</label>
                    </div>
                  </div>
              </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection

@section('script')

@endsection