@extends('layouts.master')

@section('Digital shop', 'Page Title')

@section('sidebar')
    @parent
@endsection

@inject('countries', 'App\Http\Utilities\Country')
@inject('states', 'App\Http\Utilities\State')

@section('content')
@if (session()->has('successful'))
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
          <div class="alert alert-success"><strong>{{session()->get('successful')}}</strong></div>
      </div>
    </div>
@endif
<div class="row checkout-panel">
  {!! Form::open(['url' => route('order-checkout'), 'data-parsley-validate', 'id' => 'payment-form', 'name' => 'stripe-payment-form']) !!}
  <div class="col-md-9">
    <div class="panel-group checkout" id="accordion">
      <div class="panel panel-default">
         <div class="panel-heading heading-iconed">
            <h4 class="panel-title">
               <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
               <i class="icon-left"><i class="fa fa-map-marker"></i></i> Shipping Information
               </a>
            </h4>
         </div>
         <div id="collapseTwo" class="panel-collapse collapse">
            <div class="panel-body">
                  <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                           {!! Form::label('firstName', 'First Name') !!}
                           {!! Form::text('first_name', 'Enter First Name', [
                               'class'                         => 'form-control',
                               'required'                      => 'required',
                               'data-parsley-required-message' => 'First name is required',
                               'data-parsley-trigger'          => 'change focusout',
                               'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                               'data-parsley-minlength'        => '2',
                               'data-parsley-maxlength'        => '32',
                               'data-parsley-class-handler'    => '#first-name-group'
                               ]) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                           {!! Form::label('lastName', 'Last Name') !!}
                           {!! Form::text('last_name', 'Enter Last Name', [
                               'class'                         => 'form-control',
                               'required'                      => 'required',
                               'data-parsley-required-message' => 'Last name is required',
                               'data-parsley-trigger'          => 'change focusout',
                               'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                               'data-parsley-minlength'        => '2',
                               'data-parsley-maxlength'        => '32',
                               'data-parsley-class-handler'    => '#last-name-group'
                               ]) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label('country', 'Country') !!}
                          {!! Form::select('country', array_flip($countries->all()), Input::old('state'), [
                              'class'       => 'form-control',
                              'required'                      => 'required',
                              'data-parsley-required-message' => 'State is required',
                              'data-parsley-trigger'          => 'change focusout',
                              ]) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label('state', 'State') !!}
                          {!! Form::select('state', $states->all(), Input::old('state'), [
                          'class'       => 'form-control',
                          'required'                      => 'required',
                          'data-parsley-required-message' => 'State is required',
                          'data-parsley-trigger'          => 'change focusout',
                          ]) !!}
                        </div>
                     </div>
                     <div class="col-md-6">
                        <div class="form-group">
                          {!! Form::label('phone_number', 'Phone Number') !!}
                           {!! Form::text('phone_number', 'Enter Phone Number (Eg: 1234567890)', [
                               'class'                         => 'form-control',
                               'required'                      => 'required',
                               'data-parsley-type'             => 'number',
                               'data-parsley-trigger'          => 'change focusout',
                               'maxlength'                     => '5'
                               ]) !!}
                        </div>
                     </div>
                     <div class="col-md-5">
                        <div class="form-group">
                           {!! Form::label('zip_code', 'Zip Code') !!}
                           {!! Form::text('zip_code', 'Enter Zip Code', [
                               'class'                         => 'form-control',
                               'required'                      => 'required',
                               'data-parsley-type'             => 'number',
                               'data-parsley-trigger'          => 'change focusout',
                               'maxlength'                     => '5'
                               ]) !!}
                        </div>
                     </div>
                  </div>
                  <div class="form-group">
                     {!! Form::label('address_line', 'Address Line 1') !!}
                     {!! Form::text('address_line', 'Enter Address Line 1', [
                         'class'                         => 'form-control',
                         'required'                      => 'required',
                         'data-parsley-required-message' => 'Address Line 1 is required',
                         'data-parsley-trigger'          => 'change focusout',
                         'data-parsley-minlength'        => '5',
                         'data-parsley-maxlength'        => '255'
                         ]) !!}
                  </div>
                  <div class="form-group">
                    {!! Form::label('address_line2', 'Address Line 2') !!}
                    {!! Form::text('address_line2', 'Enter Address Line 2', [
                        'class'                         => 'form-control',
                        'data-parsley-trigger'          => 'change focusout'
                        ]) !!}
                  </div>
            </div>
         </div>
      </div>
      <div class="panel panel-default">
         <div class="panel-heading heading-iconed">
            <h4 class="panel-title">
               <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
               <i class="icon-left"><i class="fa fa-credit-card"></i></i> Payment Information
               </a>
            </h4>
         </div>
         <div id="collapseFour" class="panel-collapse collapse">
            <div class="panel-body">
               <p>Please fill in payment details.</p>
               <hr>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group" id="first-name-group">
                        {!! Form::label('firstName', 'First Name:') !!}
                        {!! Form::text('first_name', null, [
                            'class'                         => 'form-control stripe_first_name',
                            'required'                      => 'required',
                            'data-parsley-required-message' => 'First name is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                            'data-parsley-minlength'        => '2',
                            'data-parsley-maxlength'        => '32',
                            'data-parsley-class-handler'    => '#first-name-group'
                            ]) !!}
                     </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="last-name-group">
                        {!! Form::label('lastName', 'Last Name:') !!}
                        {!! Form::text('last_name', null, [
                            'class'                         => 'form-control stripe_last_name',
                            'required'                      => 'required',
                            'data-parsley-required-message' => 'Last name is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-pattern'          => '/^[a-zA-Z]*$/',
                            'data-parsley-minlength'        => '2',
                            'data-parsley-maxlength'        => '32',
                            'data-parsley-class-handler'    => '#last-name-group'
                            ]) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="cc-group">
                        {!! Form::label(null, 'Credit card number:') !!}
                        {!! Form::text(null, null, [
                            'class'                         => 'form-control',
                            'required'                      => 'required',
                            'data-stripe'                   => 'number',
                            'data-parsley-type'             => 'number',
                            'maxlength'                     => '16',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-class-handler'    => '#cc-group'
                            ]) !!}
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group" id="email-group">
                        {!! Form::label('email', 'Email address:') !!}
                        {!! Form::email('email', null, [
                            'class' => 'form-control',
                            'placeholder'                   => 'email@example.com',
                            'required'                      => 'required',
                            'data-parsley-required-message' => 'Email name is required',
                            'data-parsley-trigger'          => 'change focusout',
                            'data-parsley-class-handler'    => '#email-group'
                            ]) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="exp-m-group">
                        {!! Form::label(null, 'Ex. Month') !!}
                        {!! Form::selectMonth(null, null, [
                            'class'                 => 'form-control',
                            'required'              => 'required',
                            'data-stripe'           => 'exp-month'
                        ], '%m') !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="exp-y-group">
                        {!! Form::label(null, 'Ex. Year') !!}
                        {!! Form::selectYear(null, date('Y'), date('Y') + 10, null, [
                            'class'             => 'form-control',
                            'required'          => 'required',
                            'data-stripe'       => 'exp-year'
                            ]) !!}
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group" id="ccv-group">
                        {!! Form::label(null, 'Card Validation Code (3 or 4 digit number):') !!}
                        {!! Form::text(null, null, [
                            'class'                         => 'form-control',
                            'required'                      => 'required',
                            'data-stripe'                   => 'cvc',
                            'data-parsley-type'             => 'number',
                            'data-parsley-trigger'          => 'change focusout',
                            'maxlength'                     => '4',
                            'data-parsley-class-handler'    => '#ccv-group'
                            ]) !!}
                    </div>
                  </div>
               </div>
               <hr>

               <div class="row">
                 <div class="col-md-12">
                     <span class="payment-errors" style="color: red;margin-top:10px;"></span>
                 </div>
               </div>
            </div>
         </div>
      </div>
      </div>
  </div>
  <div class="col-md-3">
    <div class="checkout-summary">
      <table>
        <tbody>
          <tr>
            <td>({{$quantity}}) Items</td>
            <td class="price">${{number_format($total,2,'.','')}}</td>
          </tr>
          <tr>
            <td>Standard Shipping Price</td>
            <td class="price"><span class="success">${{number_format(25,2,'.','')}}</span></td>
          </tr>
          <tr class="total">
            <td> Total </td>
            @if($total)
            <td class="price accent-2">${{number_format($total + 25,2,'.','')}}</td>
            @else
            <td class="price accent-2">${{number_format($total,2,'.','')}}</td>
            @endif
          </tr>
        </tbody>
      </table>
      <a href="/cart" class="btn btn-block btn-bigger accent-0 accent-bg-1">View Cart</a>
      {!! Form::submit('Checkout', ['class' => 'btn btn-block btn-bigger accent-0 accent-bg-2', 'id' => 'submitBtn', 'style' => 'margin-bottom: 10px;']) !!}
    </div>
  </div>
  {!! Form::close() !!}

  {{-- Show $request errors after back-end validation --}}
  <div class="col-md-6 col-md-offset-3">
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
</div>

</div>
</div>
@endsection
