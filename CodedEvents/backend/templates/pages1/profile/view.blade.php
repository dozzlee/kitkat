@extends('layouts.master')

@section('Digital shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
<div class="container" style="margin-top:50px;">
    <div class="well row">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="">
                <div class="row col-xs-12">
                    <div class="col-sm-6 col-md-4">
                        <img src="http://placehold.it/380x500" alt="" class="img-rounded img-responsive" />
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h4>{{$user->first_name}} {{$user->last_name}}</h4>
                        @if($address)
                        <small><cite title="San Francisco, USA">{{$address->address_line_1}}, {{$address->country}} <i class="fa fa-map-marker">
                        @endif
                        </i></cite></small>
                        <p class="profile-block">
                            <i class="fa fa-envelope"></i>{{$user->email}}
                            <br />
                            <i class="fa fa-phone"></i>+{{$user->phone_number}}
                            <br />
                            <a class="btn btn-warning" data-toggle="modal" data-target="#myModal"><i class="fa fa-edit"></i> Edit Personal Information</a>
                          </p>

                          <!-- Modal -->
                          <div id="myModal" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                              <!-- Modal content-->
                              <div class="modal-content">
                                <div class="modal-header accent-bg-1">
                                  <button type="button" class="close accent-0 accent-bg-0" data-dismiss="modal">&times;</button>
                                  <h4 class="modal-title accent-0" style="font-weight:bold;"><i class="fa fa-edit"> Edit Profile Information</i></h4>
                                </div>
                                <form name="editprofile" method="POST" action="{{route('profile-edit')}}" role="form">
                                  {!! csrf_field() !!}
                                  <div class="modal-body">
                                    <div class="row">
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>First Name</label>
                                             <input type="text" value="{{$user->first_name}}" class="form-control" name="firstName" placeholder="Edit First Name">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Last Name</label>
                                             <input type="text" value="{{$user->last_name}}" class="form-control" name="lastName" placeholder="Edit Last Name">
                                          </div>
                                       </div>
                                       <div class="col-md-6">
                                          <div class="form-group">
                                             <label>Email Address</label>
                                             <input type="text" value="{{$user->email}}" class="form-control" name="email" placeholder="Edit Email Address">
                                          </div>
                                       </div>
                                       <div class="col-md-3">
                                          <div class="form-group">
                                             <label>Phone Number</label>
                                             <input type="text" value="{{$user->phone_number}}" class="form-control" name="phoneNumber" placeholder="Edit Phone Number">
                                          </div>
                                       </div>
                                     </div>
                                  </div>
                                  <div class="modal-footer">
                                    <input type="hidden" value="{{$user->id}}" name="userID">
                                    <button type="submit" class="btn btn-default accent-bg-5 accent-0">Save</button>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
