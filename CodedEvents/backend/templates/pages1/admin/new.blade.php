@extends('layouts.master')

@section('New Product', 'Page Title')

@section('sidebar')
    @parent
@endsection

@section('content')
    <div class="row" style="margin-top:50px; margin-bottom:10px;">
        <div class="col-sm-6">
            <a href="/admin/products"><button class="btn btn-success pull-left accent-bg-5"><i class="fa fa-arrow-left"></i> View Product Inventory</button></a>
        </div>
        <div class="col-sm-6">
            <a href="/admin/orders"><button class="btn btn-primary pull-right accent-bg-4">View Orders History <i class="fa fa-arrow-right"></i></button></a>
        </div>
    </div>
    <div class="panel panel-info" style="">
        <div class="panel-heading accent-bg-4">
            <div class="panel-title accent-0"><i class="fa fa-plus"> Add New Product</i></div>
        </div>
        <div class="panel-body">
            <form method="POST" action="/admin/product/add" class="form-horizontal" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}
                <fieldset>
                    <!-- Text input-->
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="name">Name</label>
                        <div class="col-md-9">
                            <input id="name" name="name" type="text" placeholder="Product name" class="form-control input-md" required="">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="textarea">Description</label>
                        <div class="col-md-9">
                            <textarea class="form-control" id="textarea" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="price">Price</label>
                        <div class="col-md-9">
                            <input id="price" name="price" type="text" placeholder="Product price" class="form-control input-md" required="">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="productStock">Number in stock</label>
                        <div class="col-md-9">
                            <input id="productStock" name="productStock" type="text" placeholder="Number in stock" class="form-control input-md" >

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="file">File</label>
                        <div class="col-md-9">
                            <input id="file" name="file" class="input-file" type="file">
                        </div>
                    </div>
                    <div class="form-group" style="float:right;">
                        <label class="col-md-3 control-label" for="submit"></label>
                        <div class="col-md-9">
                            <button id="submit" name="submit" class="btn btn-primary accent-bg-5 accent-0"><i class="fa fa-save"> Save</i></button>
                        </div>
                    </div>

                </fieldset>

            </form>
        </div>
    </div>
@endsection
