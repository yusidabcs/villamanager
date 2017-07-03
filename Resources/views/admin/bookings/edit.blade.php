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
          <b>Data User</b>  : <label class="text-info">< {{ $booking->user ? $booking->user->roles->first()->name : 'Guest' }} ></label>
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">

            <strong>{{ $booking->title. ' '.$booking->first_name.' '.$booking->last_name }}</strong><br>
              From: {{ $booking->country ? $booking->country->country_name : ' - '}}<br>
              Address: {{ $booking->address }}<br>
              Zip: {{ $booking->zip }} <br>
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

          <b>Payment Detail</b> :
          {!! $booking->status() !!}
          <br>
          <div class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
          <b>Total paid</b>
          <h4 class="text-success"><strong><span id="price" >{{ currency($booking->total_paid) }}</span> </strong></h4>
          <b>Remaining Payment</b>
          <h4 class="text-success"><strong><span id="price" >{{ currency($booking->remaining_payment) }}</span> </strong></h4>

          <b>Total Commission</b>
          <h4 class="text-success"><strong><span id="price" >{{ currency($booking->total_commission ? $booking->total_commission : 0) }}</span> </strong></h4>
          </div>

        </div>
        <!-- /.col -->
      </div>
      <hr>
      <!-- /.row -->
      {!! Form::open(['method' => 'put' , 'url' => route('admin.villamanager.booking.update',$booking->id)]) !!}
      <!-- Table row -->
      <div class="row">
        <div class="col-xs-8 table-responsive">
          <h3><i class="fa fa-building"></i> Villa Detail</h3>
          <p class="lead">{{ $booking->villa->name }}</p>
          <p>{{ $booking->villa->short_description }}</p>
        </div>
        <div class="col-xs-4 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th width="200">Update Booking</th>
            </tr>
            </thead>
            <tbody>

            <tr>

              <td align="right">
              <?php $status = new \Modules\Villamanager\Entities\Status;?>
              <select class="form-control pull-right" name="status">
                <option value="0" {{ $booking->status == 0 ? 'selected' : '' }}>{{ $status->get(0) }}</option>
                <option value="1" {{ $booking->status == 1 ? 'selected' : '' }}>{{ $status->get(1) }}</option>
                  <option value="2" {{ $booking->status == 2 ? 'selected' : '' }}>{{ $status->get(2) }}</option>
                  <option value="3" {{ $booking->status == 2 ? 'selected' : '' }}>{{ $status->get(3) }}</option>
                  <option value="4" {{ $booking->status == 2 ? 'selected' : '' }}>{{ $status->get(4) }}</option>
                  <option value="5" {{ $booking->status == 2 ? 'selected' : '' }}>{{ $status->get(5) }}</option>
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

    {!! Form::close() !!}
    </section>
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop

@section('scripts')
    
@stop