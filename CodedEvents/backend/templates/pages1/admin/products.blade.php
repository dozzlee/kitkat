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
            <div class="col-sm-6">
                <a href="/admin/product/new"><button class="btn btn-success pull-left accent-bg-5"><i class="fa fa-plus"></i> Add New Product</button></a>
            </div>
            <div class="col-sm-6">
                <a href="/admin/orders"><button class="btn btn-primary pull-right accent-bg-4">View Orders <i class="fa fa-arrow-right"></i></button></a>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="item-list table table-striped" style="border:1px solid #ddd; margin-bottom:60px;">
                   <thead>
                      <tr>
                         <th>Product</th>
                         <th>Description</th>
                         <th>Price</th>
                         <th>In Stock</th>
                         <th></th>
                      </tr>
                   </thead>
                   <tbody>
                     @foreach($products as $product)
                     <form name="productinv-{{$product->id}}" method="POST" action="{{route('cart-edit-item')}}" role="form">
                       {!! csrf_field() !!}
                      <tr>
                         <td class="image hidden-xs"><img src="{{$product->imageurl}}" alt="{{$product->name}}"></td>
                         <td class="details">
                            <div class="clearfix">
                               <div class="pull-left no-float-xs">
                                  <a href="#" class="title">{{$product->name}}</a>
                                  <div class="">
                                     {{$product->description}}
                                  </div>
                                  <span>Product Code: PID{{$product->id}}</span>
                               </div>
                            </div>
                         </td>
                         <td class="unit-price hidden-xs"><span class="currency">$</span>{{number_format($product->price,2,'.','')}}</td>
                         <td class="total-price accent-2"><span class="currency"></span>{{$product->product_stock}}</td>
                         <td class="qty">
                           <div class="action pull-right no-float-xs">
                              <div class="clearfix">
                                 <button data-toggle="modal" data-target="#myModal-{{$product->id}}" class="save" type="button"><i class="fa fa-edit"></i></button>
                                 <a href="/admin/product/destroy/{{$product->id}}" class="btn accent-bg-2 accent-0" style="height:30px;"><i class="fa fa-trash-o"></i></a>
                              </div>
                           </div>
                         </td>
                      </tr>
                      </form>

                      <!-- Modal -->
                      <div id="myModal-{{$product->id}}" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                          <!-- Modal content-->
                          <div class="modal-content">
                            <div class="modal-header accent-bg-1">
                              <button type="button" class="close accent-0 accent-bg-0" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title accent-0"><i class="fa fa-edit"> Edit Product Information</i></h4>
                            </div>
                            <form name="editproduct-{{$product->id}}" method="POST" action="{{route('product-edit-item')}}" role="form">
                              {!! csrf_field() !!}
                              <div class="modal-body">
                                <div class="row">
                                   <div class="col-md-6">
                                      <div class="form-group">
                                         <label>Product Name</label>
                                         <input type="text" value="{{$product->name}}" class="form-control" name="productName" placeholder="Edit Product Name">
                                      </div>
                                   </div>
                                   <div class="col-md-3">
                                      <div class="form-group">
                                         <label>Product Price</label>
                                         <input type="text" value="{{$product->price}}" class="form-control" name="productPrice" placeholder="Edit Product Price">
                                      </div>
                                   </div>
                                   <div class="col-md-3">
                                      <div class="form-group">
                                         <label>Product Stock</label>
                                         <input type="text" value="{{$product->product_stock}}" class="form-control" name="productStock" placeholder="Edit Product Stock">
                                      </div>
                                   </div>
                                   <div class="col-md-12">
                                      <div class="form-group">
                                         <label>Product Description</label>
                                         <textarea type="text" class="form-control" name="productDescription" placeholder="Edit Product Description">
                                            {{$product->description}}
                                         </textarea>
                                      </div>
                                   </div>
                                 </div>
                              </div>
                              <div class="modal-footer">
                                <input type="hidden" value="{{$product->id}}" name="productId">
                                <button type="submit" class="btn btn-default accent-bg-5 accent-0">Save</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>

                      @endforeach
                   </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
