
@extends('layouts/contentLayoutMaster')

@section('title', 'User')

@section('content')

<section class="bs-validation">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Tambah Data</h4>
                </div>

                <div class="card-body">
                    {!! Form::open(['route' => 'user.store', 'class' => 'form_ajax', 'autocomplete'=>"off"]) !!}

                        {{ Form::vText('nama', 'name') }}
                        {{ Form::vSelect('role', 'role_id', $roles) }}
                        {{ Form::vEmail('email') }}

                        <div class="form-group">
                            <label for="password-new">Password</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="password" name="password" aria-describedby="password" />
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">Konfirmasi Password</label>
                            <div class="input-group input-group-merge form-password-toggle">
                                <input type="password" class="form-control form-control-merge" id="password-confirm" name="password-confirm" aria-describedby="password-confirm"/>
                                <div class="input-group-append">
                                    <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            {!! Form::submit('Simpan', ['class' => 'btn btn-primary']) !!}
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