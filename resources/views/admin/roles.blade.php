@extends('layouts.template')
@section('title')
    User Roles
@endsection

@section('content')
    <div class="row-fluid">
        @include('admin.settings-menu')

        <div class="span10">
            <div class="alert alert-info">
                When you create new modules, add them here and assign permissions. For example if module is
                <code>users</code>, then permissions are generated as
                <code>create-users</code>
                <code>read-users</code>
                <code>update-users</code>
                <code>delete-users</code>.
                In your module code, you can define access using
                <div class="row-fluid">
                    <div class="span5">
                        <code>
                            if(\Trust::can('create-users')<br/>
                            &nbsp; &nbsp; &nbsp;---your code here---<br/>
                            &nbsp;endif
                        </code>
                    </div>
                    <div class="span2">or</div>
                    <div class="span5">
                        <code>
                            &commat;if(permission('create-users')<br/>
                            &nbsp; &nbsp; &nbsp;---your code here---<br/>
                            &nbsp;&commat;endif
                        </code>
                    </div>
                </div>

                <p>
                    Default modules
                    <code>users</code>
                    <code>gifts</code>
                    <code>ministries</code>
                    <code>sermons</code>
                    <code>events</code>
                    <code>birthdays</code>
                    <code>tickets</code>
                    <code>mail</code>
                    <code>blog</code>
                </p>
            </div>
            <div class="row-fluid">

                <div class="span3">
                    <div class="">
                        <strong>Roles</strong>
                        <a href="#" data-toggle="tooltip" title="Add a role" class="pull-right create-role-btn"><i
                                    class="icon-plus"></i></a>
                    </div>
                    <div id="roles">
                        <input class="search form-control input-sm" placeholder="Search"/><br/>
                        <i>double a role click to edit</i>
                        <ul class="list nav nav-pills nav-stacked">
                            @foreach($roles as $role)
                                <li id="{{$role->id}}" data-toggle="tooltip" title="{{$role->desc}}">
                                    <a href="#" class="role" id="{{$role->id}}">
                                        {{ucwords($role->display_name)}}
                                        <span class="pull-right"><i class="icon-chevron-right"
                                                                    style="opacity: 0.2;"></i> </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <ul class="pagination"></ul>
                    </div>
                </div>
                <div class="span3">
                    <div class="">
                        <strong>Modules</strong>
                        <a href="#" data-toggle="tooltip" title="Register a module"
                           class="pull-right register-module-btn"><i
                                    class="icon-plus"></i></a>
                    </div>
                    <div id="modules">

                    </div>

                </div>
                <div class="span3">
                    <strong>Permissions</strong><br/>
                    <div id="permissions">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script src="/plugins/listjs/listjs.min.js"></script>
<script src="/js/roles.js"></script>
@endpush

@push('modals')

<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel"><i class="icon-plus-circle"></i> New Role</h4>
            </div>
            {!! Form::open(['url'=>'/roles']) !!}
            <div class="modal-body">
                <label>Name <i class="small">(no spaces or special characters)</i></label>
                {!! Form::text('name',null,['class'=>'form-control']) !!}
                <label>Display name</label>
                {!! Form::text('display_name',null,['class'=>'form-control']) !!}
                <label>Description</label>
                {!! Form::textarea('description',null,['rows'=>2,'class'=>'form-control']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Submit</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


<div class="modal fade" id="modulesModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">New Module</h4>
            </div>
            {!! Form::open(['url'=>route('modules.store'),'method'=>'post']) !!}
            <div class="modal-body">
                <label>Name<i class="small">(no spaces or special characters)</i></label>
                {!! Form::text('name',null,['required'=>'required','class'=>'form-control']) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary">Submit</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endpush