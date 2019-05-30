@extends('layouts.master')

@section('Digital shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
<div class="product-details-section details_page" style="margin-right:2%;">
  <div class="breadcrumb"><a href="/">Shop</a> &gt; {{$product->name}}</div>
  <section class="product-details-product-img">
      <div class="product-details-product-image-holder">
          <div>
            <a><img src="{{$product->imageurl}}" alt=""></a>
          </div>
      </div>
  </section>
  <section class="product-details-desc">
      <h1>{{$product->name}}</h1>
      <div class="product-details-line"></div>
      <ul>
          <li><span>Brand:</span> <a href="#">{{$product->name}}</a></li>
          <li><span>Product Code:</span>{{$product->id}}</li>
          <li><span>Availability: </span>
            @if($product->product_stock > 0)
              <span class="accent-1">In Stock</span>
            @else
              <span class="accent-2"><strong>Out of Stock</strong></span>
            @endif
          </li>
      </ul>
      <div class="product-details-price">
          Price<strong> ${{number_format($product->price,2,'.','')}}</strong>
      </div>
      <div class="product-details-line"></div>
      <form name="addtocartform" method="POST" action="{{route('cart-add-item')}}" role="form">
        {!! csrf_field() !!}
        <input type="hidden" name="command" />
        <input type="hidden" name="link" />
        <input type="hidden" name="productId" value="{{$product->id}}"/>
        @if($product->product_stock > 0)
          <button type="submit" class="product-details-btn product-details-btn-cart">Add to Cart</button>
        @else
          <button type="submit" style="opacity:0.4;" class="product-details-btn product-details-btn-cart" disabled>Add to Cart</button>
        @endif
        <label>Qty:</label>
        <input type="text" placeholder="1" class="product-details-qty-holder" name="quantity">
      </form>
      <div class="product-details-tabs">
          <ul class="product-details-nav product-details-nav-tabs">
              <li class="active" style="width:100%;"><a>Description</a></li>
          </ul>
          <div class="product-details-tab-content">
              <div class="product-details-tab-pane active tab-0">{{$product->description}}</div>
          </div>
      </div>
  </section>
</div>
@endsection
