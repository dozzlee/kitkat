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
              <div class="update-text">Order History Summary</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
          <div class="cart">
            <table class="table table-striped item-list">
                <thead>
                <tr>
                    <th class="col-sm-2">Order ID #</th>
                    <th class="col-sm-4">Date Ordered</th>
                    <th class="col-sm-2"></th>
                </tr>
                </thead>
                @foreach($orders as $order)
                    <tr>
                        <td>OID0000{{$order->id}}</td>
                        <td><a href="/order/{{$order->id}}" style="font-size: 11px; color: #999;"> {{$order->created_at}}</a></td>
                        <td><a href="/order/{{$order->id}}"><i class="fa fa-search-plus"></i></a></td>
                    </tr>
                @endforeach
            </table>
          </div>
        </div>
    </div>
@endsection
