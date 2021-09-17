@extends('layouts/contentLayoutMaster')

@section('title', 'User')

@section('content')

<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Data</h4>
                    <div class="heading-elements mb-0">
                        <ul class="list-inline mb-0">
                            <li> <a data-toggle="collapse" data-target="#collapseFilter" title="pencarian"><i class="fas fa-search fa-lg"></i></a> </li>
                            <li> <a class="btn-link" data-route="{{ route('user.create') }}" title="tambah data"><i class="fas fa-plus fa-lg"></i></a> </li>
                        </ul>
                    </div>
                </div>
                <!--Search Form -->
                <div class="collapse-margin ml-2 mr-2" id="accordionExample">
                    <div class="card">
                        <div id="collapseFilter" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <h5 class="card-header p-1">Pencarian</h5>
                            <div class="card-body">
                                <div class="d-flex row pt-0 pb-0 filter-table">
                                    <div class="col-md-4">
                                        {{ Form::vText('nama', 'name') }}
                                    </div>
                                    <div class="col-md-4">
                                        {{ Form::vSelect('role', 'role_id', $roles) }}            
                                    </div>
                                </div>
                                <div>
                                    {!! Form::button('<i class="fas fa-search"></i> Cari', ['class' => 'submit-filter btn btn-success btn-sm', 'data-target' => 'users-table', 'value'=> 'submit']) !!}
                                    {!! Form::button('<i class="fas fa-redo"></i> Reset', ['class' => 'submit-filter btn btn-outline-danger btn-sm', 'data-target' => 'users-table', 'value'=> 'reset']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-datatable">
                    <table class="dt-advanced-search table" id="users-table">
                        <thead>
                            <tr>
                                <th width="3%"></th>
                                <th width="35%">Name</th>
                                <th width="20%">Email</th>
                                <th width="20%">Role</th>
                                <th width="10%">Active</th>
                                <th width="12%"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection


@section('page-script')

<script>
    var table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url : '{!! route('user.data.list') !!}',
            data: function (d) {
                d.name  = $('input[name=name]').val();
                d.role_id = $('select[name=role_id]').val();
            },
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false},
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'role_name', name: 'role_name' },
            { data: 'active', name: 'active' },
            { data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order:[[4,'asc']],
        drawCallback: function( settings ) { feather.replace() },
        dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
        language: { paginate: { previous: '&nbsp;', next: '&nbsp;' } }
    });

    $('.submit-filter').on('click', function(e) {
        if ($(this).val() == 'reset') $('.filter').val('');
        table.draw();
    });
</script>
  
@endsection