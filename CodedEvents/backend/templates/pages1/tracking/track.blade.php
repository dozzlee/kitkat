@extends('layouts.master')

@section('Digital shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
    @if (session()->has('successful'))
        <div class="row">
          <div class="col-md-6 col-md-offset-3">
              <div class="alert alert-success"><strong>{{session()->get('successful')}}</strong></div>
          </div>
        </div>
    @endif

    <div class="row shop-tracking-status">

    {{-- Show $request errors after back-end validation --}}
    <div class="col-md-12" style="margin-top:30px;">
        @if($errors->has())
            <div class="alert alert-danger fade in">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4>The following errors occurred</h4>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <div class="col-md-12">
        <div class="well">
          <h4 style="font-size:15px;font-weight:normal;">Track all order items.</h4>
          {!! Form::open(['url' => route('order-tracking'), 'data-parsley-validate', 'id' => 'tracking-form', 'name' => 'order-tracking-form']) !!}
            <div class="form-horizontal row">
              <div class="col-md-9" style="margin-left:20px;">
                 <div class="form-group" id="trackingID">
                    {!! Form::label('orderID', 'OrderID:') !!}
                    {!! Form::text('tracking_id', null, [
                        'class'                         => 'form-control',
                        'required'                      => 'required',
                        'data-parsley-required-message' => 'Order id is required',
                        'data-parsley-trigger'          => 'change focusout',
                        'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                        'data-parsley-minlength'        => '1',
                        'data-parsley-maxlength'        => '32',
                        'data-parsley-class-handler'    => '#order-id'
                        ]) !!}
                 </div>
              </div>
              <div class="col-md-2" style="margin-top:25px;">
                 <div class="form-group" id="">
                   {!! Form::submit('Track Order', ['class' => 'btn btn-block btn-bigger btn-success', 'id' => 'submitBtn', 'style' => 'margin-bottom: 10px;']) !!}
                 </div>
              </div>
            </div>
          {!! Form::close() !!}

          <div class="order-status">
              <div class="order-status-timeline">
                  <!-- class names: c0 c1 c2 c3 and c4 -->
                  <div class="order-status-timeline-completion c0"></div>
              </div>

              <div class="image-order-status image-order-status-new active img-circle">
                  <span class="status">Accepted</span>
                  <div class="icon"></div>
              </div>
              <div class="image-order-status image-order-status-active active img-circle">
                  <span class="status">In progress</span>
                  <div class="icon"></div>
              </div>
              <div class="image-order-status image-order-status-intransit active img-circle">
                  <span class="status">Shipped</span>
                  <div class="icon"></div>
              </div>
              <div class="image-order-status image-order-status-delivered active img-circle">
                  <span class="status">Delivered</span>
                  <div class="icon"></div>
              </div>
              <div class="image-order-status image-order-status-completed active img-circle">
                  <span class="status">Completed</span>
                  <div class="icon"></div>
              </div>

          </div>

          <h4>Order summary:</h4>

          <ul class="list-group">
              <li class="list-group-item">
                  <span class="prefix">Date created:</span>
                  <span class="label label-success">Enter order ID # to view tracking information.</span>
              </li>
              <li class="list-group-item">
                  <span class="prefix">Last update:</span>
                  <span class="label label-success">Enter order ID # to view tracking information.</span>
              </li>
              <li class="list-group-item">
                  <span class="prefix">Status:</span>
                  <span class="accent-1">Enter order ID # to view tracking information.</span>
              </li>
          </ul>
        </div>
    </div>

</div>
@endsection
