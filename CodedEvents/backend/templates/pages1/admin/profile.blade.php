@extends('layouts.master')

@section('Admin shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="container" style="margin-top:40px;">
        @if (session()->has('error'))
            <div class="row">
              <div class="col-md-12">
                  <div class="alert alert-warning"><strong>{{session()->get('error')}}</strong></div>
              </div>
            </div>
        @endif
        <div class="row" style="margin-bottom:10px;">
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <a href="/admin/products"><button class="btn btn-primary pull-right accent-bg-4">View Product Inventory <i class="fa fa-arrow-right"></i></button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped">
                    <thead>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Email Address</td>
                    <td>Phone Number</td>
                    <td>User Status</td>
                    <td></td>
                    <td></td>
                    </thead>
                    <tbody>
                    @foreach ($users as $user)
                      <form name="userform-{{$user->id}}" method="POST" action="{{route('admin-profile-edit')}}" role="form">
                        {!! csrf_field() !!}
                        <tr>
                            <td>{{$user->first_name}}</td>
                            <td>{{$user->last_name}}</td>
                            <td>{{$user->email}}</td>
                            <td>+{{$user->phone_number}}</td>
                            <td class="qty">
                               {!! Form::select('admin_status', array('Standard User', 'Super User'), $user->is_admin , array()); !!}
                               <input type="hidden" name="userID" value="{{$user->id}}"/>
                            </td>
                            <td class="details">
                              <div class="clearfix">
                                <div class="action pull-right no-float-xs">
                                   <div class="clearfix">
                                      <button class="save btn" type="submit"><i class="fa fa-save"></i></button>
                                      <a class="btn delete accent-0 accent-bg-2" href="/admin/user/destroy/{{$user->id}}"><i class="fa fa-trash-o"></i></a>
                                   </div>
                                </div>
                              </div>
                            </td>
                        </tr>
                      </form>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
