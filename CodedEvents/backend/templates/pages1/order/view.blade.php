@extends('layouts.master')

@section('Digital shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12" style="margin-top:10px;">
            <div class="update-nag">
              <div class="update-split accent-bg-6"><i class="fa fa-info"></i></div>
              <div class="update-text">Order ID #OID0000{{$order->id}} <a href="/tracking/{{$order->id}}" class="accent-2">Track order <i class="fa fa-arrow-right"></i></a> </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="cart">
           <table class="item-list">
              <thead>
                 <tr>
                    <th class="hidden-xs">Image</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th class="hidden-xs">Price</th>
                    <th>Total</th>
                 </tr>
              </thead>
              <tbody>
                @foreach($order->orderItems as $item)
                 <tr>
                    <td class="image hidden-xs"><img src="/download/{{$order->id}}/{{$item->file->filename}}" alt="{{$item->product->name}}"></td>
                    <td class="details">
                       <div class="clearfix">
                          <div class="pull-left no-float-xs">
                             <a href="#" class="title">{{$item->product->name}}</a>
                             <div class="">
                                {{$item->product->description}}
                             </div>
                             <span>Product Code: PID{{$item->product->id}}</span>
                          </div>
                       </div>
                    </td>
                    <td class="unit-price hidden-xs"><span class="qty"></span>{{$item->quantity}}</td>
                    <td class="unit-price hidden-xs"><span class="currency">$</span>{{number_format($item->product->price,2,'.','')}}</td>
                    <td class="total-price accent-2"><span class="currency">$</span>{{number_format($item->product->price * $item->quantity,2,'.','')}}</td>
                 </tr>
                 @endforeach
              </tbody>
           </table>
           <table class="cart-summary">
              <tbody>
                 <tr>
                    <td style="width:100%;">
                    </td>
                    <td class="totals">
                       <table class="cart-totals">
                          <tbody>
                             <tr>
                                <td>Sub Total</td>
                                <td class="price">${{number_format($order->total_paid,2,'.','')}}</td>
                             </tr>
                             <tr>
                                <td>Shipping</td>
                                <td class="price">{{number_format(25,2,'.','')}}</td>
                             </tr>
                             <tr>
                                <td class="cart-total">Total</td>
                                <td class="cart-total price accent-2">${{number_format($order->total_paid + 25,2,'.','')}}</td>
                             </tr>
                          </tbody>
                       </table>
                    </td>
                 </tr>
              </tbody>
           </table>
        </div>
    </div>
@endsection
