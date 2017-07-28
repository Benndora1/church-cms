<?php
$thisMonth = date('m');
$nextMonth = date('m', strtotime(\Carbon\Carbon::now()->addMonths(1)));
?>
@extends('layouts.template')
@section('title')
    Registered Users
@endsection

@section('content')


    @if(isset($_GET['s']))
        <a href="/users" class="btn btn-default btn-mini">
            <i class="icon-chevron-circle-left"></i>
        </a>
    @endif

    <div class="row-fluid">
        <div class="span6">
            <div class="callout callout-info">
                <h4>Birthdays</h4>
                <a class="" href="/birthdays"><i class="icon-new-window"></i> View Birthdays</a> |

                <a href="/birthdays?m={{$thisMonth}}" class="">
                    <i class="badge">{{App\User::where('dob','LIKE',"%-$thisMonth-%")->count()}}</i>
                    This month
                </a> |

                <a href="/birthdays?m={{$nextMonth}}" class="">
                    <i class="badge">
                        {{App\User::where('dob','LIKE',"%-$nextMonth-%")->count()}}
                    </i>
                    Next month
                </a>
            </div>
        </div>
        <div class="span6">
            <button class="btn btn-default newUser"><i class="icon-plus"></i> New User</button>
        </div>
    </div>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-box">
                <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                    <h5>Users</h5>
                </div>
                <div class="widget-content nopadding">
                    <table class="table table-bordered data-table selec2">
                        <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Firstname</th>
                            <th>Lastname</th>
                            <th>Phone</th>
                            <th>Registered</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><a href="/user/{{$user->id}}">{{$user->username}}</a></td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->first_name}}</td>
                                <td>{{$user->last_name}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('partials.datatables')

@push('modals')

    <script type="text/javascript">
        $('document').ready(function () {
            $('.newUser').click(function () {
                $('#newUser').modal('show');
            });
        });
    </script>

    <div class="modal hide" id="newUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Register a user</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url'=>'registerUser']) !!}
                    <table class="table table-striped no-border">
                        <tr>
                            <td>Username:</td>
                            <td>{{Form::text('username')}}</td>
                        </tr>
                        <tr>
                            <td>First name:</td>
                            <td>{{Form::text('first_name')}}</td>
                        </tr>
                        <tr>
                            <td>Last name:</td>
                            <td>{{Form::text('last_name')}}</td>
                        </tr>
                        <tr>
                            <td>Email:</td>
                            <td>{{Form::input('email','email')}}</td>
                        </tr>
                        <tr>
                            <td>Phone:</td>
                            <td>{{Form::text('phone')}}</td>
                        </tr>
                        <tr>
                            <td>Address:</td>
                            <td>{{Form::textarea('address',null,['rows'=>3])}}</td>
                        </tr>
                        <tr>
                            <td>DOB:</td>
                            <td>{{Form::input('date','dob')}}</td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                {{Form::submit('Update',['class'=>'btn btn-primary btn-mini'])}}
                            </td>
                        </tr>
                    </table>
                    {!! Form::close() !!}
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
@endpush