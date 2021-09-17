
@extends('layouts/contentLayoutMaster')

@section('title', 'User')

@section('content')

<section class="bs-validation">
    <div class="row">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Data</h4>
                </div>
                <div class="card-body">
                    {!! Form::model($user, [
                            'route' => ['user.update', $user->id],
                            'method' => 'PUT',
                            'class' => 'form_ajax',
                        ]) 
                    !!}
                        {{ Form::vText('nama', 'name') }}
                        {{ Form::vSelect('role', 'role_id', $roles, $user->roleUser->role_id) }}
                        {{ Form::vEmail('email') }}

                        <div class="form-group">
                            <label class="form-label" for="">Status</label>
                            <div class="demo-inline-spacing">
                                <div class="custom-control custom-control-success custom-radio">
                                    <input type="radio" name="active" value="1" id="customRadio1" class="custom-control-input"  
                                        @if($user->active == 1)
                                            {{ 'checked' }}
                                        @endif
                                    />
                                    <label class="custom-control-label" for="customRadio1">Aktif</label>
                                </div>
                                <div class="custom-control custom-control-danger custom-radio">
                                    <input type="radio" name="active" value="0" id="customRadio2" class="custom-control-input" 
                                        @if($user->active == 0)
                                            {{ 'checked' }}
                                        @endif
                                    />
                                    <label class="custom-control-label" for="customRadio2">Tidak Aktif</label>
                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="form-group">
                            {!! Form::submit('Simpan Perubahan', ['class' => 'btn btn-primary']) !!}
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