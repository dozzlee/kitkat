@extends('layouts.master')

@section('Admin shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')

    <div class="container" style="margin-top:40px;">
        @if (session()->has('successful'))
            <div class="row">
              <div class="col-md-6 col-md-offset-3">
                  <div class="alert alert-success"><strong>{{session()->get('successful')}}</strong></div>
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
                    <td>Order ID #</td>
                    <td>User ID #</td>
                    <td>Transaction ID #</td>
                    <td>($) Transaction Amount Total</td>
                    <td>Order status</td>
                    <td></td>
                    <td></td>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order)
                      <form name="orderform-{{$order->id}}" method="POST" action="{{route('order-edit-item')}}" role="form">
                        {!! csrf_field() !!}
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->user_id}}</td>
                            <td>{{$order->stripe_transaction_id}}</td>
                            <td>${{number_format($order->total_paid,2,'.','')}}</td>
                            <td class="qty">
                               {!! Form::select('order_status', array('Accepted', 'In Progress', 'Shipped', 'Delivered', 'Completed'), $order->order_progress , array()); !!}
                               <input type="hidden" name="orderId" value="{{$order->id}}"/>
                            </td>
                            <td><a class="btn btn-primary accent-bg-3" href="/order/{{$order->id}}">View Items</a> </td>
                            <td class="details">
                              <div class="clearfix">
                                <div class="action pull-right no-float-xs">
                                   <div class="clearfix">
                                      <button class="save btn" type="submit"><i class="fa fa-save"></i></button>
                                      <a class="btn delete accent-0 accent-bg-2" href="/admin/order/destroy/{{$order->id}}"><i class="fa fa-trash-o"></i></a>
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
