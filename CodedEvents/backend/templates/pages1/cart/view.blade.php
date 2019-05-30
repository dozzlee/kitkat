@extends('layouts.master')

@section('Digital shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row" style="margin-top:30px; margin-bottom:40px;">
        <div class="col-sm-12 col-md-12">
          <div class="cart">
           <table class="item-list">
              <thead>
                 <tr>
                    <th class="hidden-xs">Product</th>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th class="hidden-xs">Price</th>
                    <th>Total</th>
                 </tr>
              </thead>
              <tbody>
                @foreach($cart as $cartItem)
                <form name="addtocartform-{{$cartItem->product->id}}" method="POST" action="{{route('cart-edit-item')}}" role="form">
                  {!! csrf_field() !!}
                 <tr>
                    <td class="image hidden-xs"><img src="{{$cartItem->product->imageurl}}" alt="{{$cartItem->product->name}}"></td>
                    <td class="details">
                       <div class="clearfix">
                          <div class="pull-left no-float-xs">
                             <a href="#" class="title">{{$cartItem->product->name}}</a>
                             <div class="">
                                {{$cartItem->product->description}}
                             </div>
                             <span>Product Code: PID{{$cartItem->product->id}}</span>
                          </div>
                          <div class="action pull-right no-float-xs">
                             <div class="clearfix">
                                <button class="save" type="submit"><i class="fa fa-save"></i></button>
                                <a href="/carts/{{$cartItem->id}}/delete" class="btn accent-bg-2 accent-0" style="height:30px;"><i class="fa fa-trash-o"></i></a>
                                <!-- </button> -->
                             </div>
                          </div>
                       </div>
                    </td>
                    <td class="qty">
                       <input type="text" value="{{$cartItem->quantity}}" name="quantity">
                       <input type="hidden" name="productId" value="{{$cartItem->product->id}}"/>
                    </td>
                    <td class="unit-price hidden-xs"><span class="currency">$</span>{{number_format($cartItem->product->price,2,'.','')}}</td>
                    <td class="total-price accent-2"><span class="currency">$</span>{{number_format($cartItem->product->price * $cartItem->quantity,2,'.','')}}</td>
                 </tr>
                 </form>
                 @endforeach
              </tbody>
           </table>
           <table class="cart-summary">
              <tbody>
                 <tr>
                    <td class="terms">
                       <h5><i class="fa fa-info-circle"></i>Important Information</h5>
                       <p>All items purchased on this website can be returned within 30 business days of purchase. This ensures
                       a full refund of items purchased with no fee incurred. Costs incurred in mailing items would be included in
                     refund.</p>
                    </td>
                    <td class="totals">
                       <table class="cart-totals">
                          <tbody>
                             <tr>
                                <td>Sub Total</td>
                                <td class="price">${{number_format($total,2,'.','')}}</td>
                             </tr>
                             <tr>
                                <td>Shipping</td>
                                <td class="price">${{number_format(25,2,'.','')}}</td>
                             </tr>
                             <tr>
                                <td class="cart-total">Total</td>
                                @if($total)
                                <td class="cart-total price accent-2">${{number_format($total + 25,2,'.','')}}</td>
                                @else
                                <td class="cart-total price accent-2">${{number_format($total,2,'.','')}}</td>
                                @endif
                             </tr>
                          </tbody>
                       </table>
                    </td>
                 </tr>
              </tbody>
           </table>
        </div>
        <div class="cart-buttons clearfix">
          <a class="btn btn-block btn-bigger accent-0 accent-bg-2" href="/checkout"><i class="icon-left fa fa-shopping-cart"></i> Go to checkout</a>
          <a class="btn btn-bigger accent-0 accent-bg-1" href="/"><i class="icon-left fa fa-arrow-left"></i> Continue Shopping</a>
        </div>
      </div>
    </div>

@endsection
