@extends('layouts/contentLayoutMaster')

@section('title', 'user')

@section('content')

<section class="bs-validation">
    <div class="row">
        <div class="col-md-12 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Password</h4>
                </div>
                <div class="card-body">

                    {!! Form::model($user, [
                            'route' => ['user.change.password.store', $user->id],
                            'class' => 'form_ajax',
                        ]) 
                    !!}

                        <div class="form-group row">
                            <label class="col-md-4 text-md-right">Nama</label>
                            <label class="col-md-6">
                                <span>{{ $user->name }}</span>
                            </label>
                        </div>

                        <div class="form-group row">
                            <label class="col-md-4 text-md-right">Email</label>
                            <label class="col-md-6">
                                <span>{{ $user->email }}</span>
                            </label>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password Baru</label>
                            <div class="col-md-6">
                                <input id="new_password" type="password" class="form-control" name="new_password">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">Konfirmasi Password Baru</label>
                            <div class="col-md-6">
                                <input id="new_confirm_password" type="password" class="form-control"
                                    name="new_confirm_password">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                {!! Form::submit('Simpan Perubahan', ['class' => 'btn btn-primary']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('page-script')
@endsection