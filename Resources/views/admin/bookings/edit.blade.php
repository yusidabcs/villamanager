@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('villamanager::bookings.title.bookings') }} <small>#{{ $booking->booking_number }}</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li class="active">{{ trans('villamanager::bookings.title.bookings') }}</li>
    </ol>
@stop

@section('content')

<section class="invoice">
      <!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> Booking Detail
            <small class="pull-right">Created at: {{ $booking->created_at }}</small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
          <b>Data User</b>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            
            <strong>{{ $booking->title. ' '.$booking->first_name.' '.$booking->last_name }}</strong><br>
            From: {{ $booking->country }}<br>
            Phone: {{ $booking->phone }}<br>
            Email: {{ $booking->email }}
          </p>
          
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">

          <b>Invoice #{{ $booking->booking_number }}</b><br>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          <b>Adult Guest:</b> {{ $booking->adult_guest }}<br>
          <b>Child Guest:</b> {{ $booking->child_guest }}<br>
          <b>Check In:</b> {{ $booking->check_in }}<br>
          <b>Check Out:</b> {{ $booking->check_out }}<br>
          </p>

        </div>

        <div class="col-sm-4 invoice-col">

          <b>Payment Detail</b>
          @if($booking->status == 0)
          <span class="label label-warning">Pending</span>
          @elseif($booking->status == 1)
          <span class="label label-success">Paid</span>
          @else
          <span class="label label-primary">Cancel</span>
          @endif
          <br>
          <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          <b>Total paid</b>
          <h4 class="text-success"><strong><span id="price" >{{ $booking->total_paid }}</span> {{ setting('core::currency') }} </strong></h4>
          <b>Remaining Payment</b>
          <h4 class="text-success"><strong><span id="price" >{{ $booking->remaining_payment }}</span> {{ setting('core::currency') }} </strong></h4>
          </div>

        </div>
        <!-- /.col -->
      </div>
      <hr>
      <!-- /.row -->
      {!! Form::open(['method' => 'put' , 'url' => route('admin.villamanager.booking.update',$booking->id)]) !!}
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-6 table-responsive">
          <h3><i class="fa fa-building"></i> Villa Detail</h3>
          <p class="lead">{{ $booking->villa->name }}</p>
          <p>{{ $booking->villa->short_description }}</p>
        </div>
        <div class="col-xs-6 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th></th>
              <th width="200">Update Booking</th>
            </tr>
            </thead>
            <tbody>
            
            <tr>
            
              <td></td>
              <td>
              <select class="form-control" name="status">
                <option value="0" {{ $booking->status == 0 ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ $booking->status == 1 ? 'selected' : '' }}>Paid</option>
                <option value="2" {{ $booking->status == 2 ? 'selected' : '' }}>Cancel</option>
              </select>
              </td>
            </tr>
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      <hr>

      <!-- this row will not appear when printing -->
      <div class="row no-print">
        <div class="col-xs-12">
          <a href="#" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
          <button type="submit" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Update
          </button>
        </div>
      </div>
    </section>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop

@section('scripts')
    
@stop