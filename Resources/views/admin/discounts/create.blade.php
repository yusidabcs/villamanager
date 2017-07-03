    @extends('layouts.master')

    @section('styles')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    @stop

    @section('content-header')
        <h1>
            {{ trans('villamanager::discounts.title.create discount') }}
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
            <li><a href="{{ route('admin.villamanager.discount.index') }}">{{ trans('villamanager::discounts.title.discounts') }}</a></li>
            <li class="active">{{ trans('villamanager::discounts.title.create discount') }}</li>
        </ol>
    @stop

    @section('content')
        {!! Form::open(['route' => ['admin.villamanager.discount.store'], 'method' => 'post']) !!}
        <div class="row">

            <div class="col-md-6">
                <div class="nav-tabs-custom">
                    <div class="tab-content">
                        <div class="box box-primary">
                            <div class="box-header">
                                <h3 class="box-title">{{ trans('core::core.title.non translatable fields') }}</h3>
                            </div>
                            <div class="box-body">
                                <div class='form-group{{ $errors->has('icon') ? ' has-error' : '' }}'>
                                    {!! Form::label('type', trans('villamanager::discounts.form.code')) !!}
                                    <div class="input-group input-group-sm">
                                        <input type="text" class="form-control" name="code" id="discount_code" value="{{ old('code') }}" >
                                        <span class="input-group-btn">
                                            <button type="button" class="btn btn-info btn-flat" id="generate">Generate!</button>
                                        </span>
                                    </div>
                                    {!! $errors->first('key', '<span class="help-block">:message</span>') !!}
                                </div>

                                <div class='form-group{{ $errors->has('type') ? ' has-error' : '' }}'>
                                    {!! Form::label('type', trans('villamanager::discounts.form.type')) !!}

                                    <select class="form-control" required="" name="type" id="type">
                                        <option value="1" {{ old('type') == '1' ? 'selected' : '' }}>Nominal</option>
                                        <option value="2" {{ old('type') == '2' ? 'selected' : '' }}>Percent</option>
                                    </select>
                                    {!! $errors->first('type', '<span class="help-block">:message</span>') !!}
                                </div>
                                <div class='form-group{{ $errors->has('discount') ? ' has-error' : '' }}' >
                                    {!! Form::label('type', trans('villamanager::discounts.form.discount')) !!}

                                    <div class="input-group">
                                        <div class="input-group-btn" id="nominal" {!! old('type') == 2   ? 'style="display: none"': ''!!} >
                                            <button type="button" class="btn btn-danger">{{ setting('core::currency')  }}</button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input type="text" class="form-control" name="discount" value="{{ old('discount') }}">

                                        <div class="input-group-btn" id="percent" {!! old('type') == 1 || old('type') == null  ? 'style="display: none"': '' !!} >
                                            <button type="button" class="btn btn-danger">%</button>
                                        </div>
                                    </div>
                                    {!! $errors->first('discount', '<span class="help-block">:message</span>') !!}
                                </div>

                                <div class='form-group{{ $errors->has('minimumPayment') ? ' has-error' : '' }}'>
                                    {!! Form::label('type', trans('villamanager::discounts.form.minimum_payment')) !!}

                                    <div class="input-group">
                                        <div class="input-group-btn">
                                            <button type="button" class="btn btn-danger">{{ setting('core::currency')  }}</button>
                                        </div>
                                        <!-- /btn-group -->
                                        <input type="text" class="form-control" name="minimumPayment" value="{{ old('minimumPayment') }}">
                                    </div>
                                    {!! $errors->first('minimumPayment', '<span class="help-block">:message</span>') !!}
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        {!! Form::label('start_date', trans('villamanager::discounts.form.start_date')) !!}
                                        <div class="input-group date" id="start_date"  data-date-format="yyyy-mm-dd"
                                             data-date-autoclose="true" >
                                            <input type="text" class="form-control" name="start_date" readonly="" value="{{ old('start_date')  }}">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                        {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
                                    </div>
                                    <div class="col-md-6">
                                        {!! Form::label('end_date', trans('villamanager::discounts.form.end_date')) !!}
                                        <div class="input-group date" id="end_date"  data-date-format="yyyy-mm-dd"
                                             data-date-autoclose="true" >
                                            <input type="text" class="form-control" name="end_date" readonly="" value="{{ old('end_date')  }}">
                                            <div class="input-group-addon">
                                                <span class="glyphicon glyphicon-th"></span>
                                            </div>
                                        </div>
                                        {!! $errors->first('end_date', '<span class="help-block">:message</span>') !!}
                                    </div>
                                </div>

                                <div class='form-group'>
                                    {!! Form::label('total', trans('villamanager::discounts.form.total')) !!}
                                    <input type="text" class="form-control" name="total" required="" value="{{ old('total')  }}">
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                            <button class="btn btn-default btn-flat" name="button" type="reset">{{ trans('core::core.button.reset') }}</button>
                            <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.villamanager.facility.index')}}"><i class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
                        </div>
                    </div>
                </div> {{-- end nav-tabs-custom --}}
            </div>
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Select Villa for the discount</h3>
                    </div>
                    <div class="box-body">
                        <div class='form-group{{ $errors->has('villa_id') ? ' has-error' : '' }}'>
                            {!! Form::label('type', trans('villamanager::discounts.form.villa')) !!}
                            <select class="form-control select2" required="" name="villa_id[]" multiple="multiple">
                                <option value="0" >All Villas</option>
                                @foreach($villas as $villa)
                                <option value="{{ $villa->id  }}" {{ old('villa_id') == $villa->id ? 'selected' : '' }}>{{ $villa->name }}</option>
                                @endforeach
                            </select>
                            {!! $errors->first('villa_id', '<span class="help-block">:message</span>') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    @stop

    @section('footer')
        <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
    @stop
    @section('shortcuts')
        <dl class="dl-horizontal">
            <dt><code>b</code></dt>
            <dd>{{ trans('core::core.back to index') }}</dd>
        </dl>
    @stop

    @section('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
        <script type="text/javascript">
            $( document ).ready(function() {
                $(document).keypressAction({
                    actions: [
                        { key: 'b', route: "<?= route('admin.villamanager.facility.index') ?>" }
                    ]
                });


                $('.select2').select2();

                    $('#generate').click(function(){
                        limit = 10;
                        var password = '';
                        var chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                        var list = chars.split('');

                        var len = list.length, i = 0;
                        do {
                            i++;
                            var index = Math.floor(Math.random() * len);
                            password += list[index];
                        } while(i < limit);
                        $("#discount_code").val(password);
                    });

                $('#type').change(function() {
                    var code = $('select[name="type"]').val();
                    if(code==2){
                        $("#nominal").hide();
                        $("#percent").show();
                    }else{
                        $("#percent").hide();
                        $("#nominal").show();
                    }
                });

                /*$('#start_date').datepicker({
                    changeMonth: true,
                    changeYear: true,

                    onSelect: function(date){
                        var selectedDate = new Date(date);
                        $('#end_date').datepicker('setStartDate', minDate);

                    }
                });

                $('#end_date').datepicker({
                    changeMonth: true,
                    changeYear: true,
                });*/

                $("#start_date").datepicker({
                    autoclose: true,
                }).on('changeDate', function (selected) {
                    var minDate = new Date(selected.date.valueOf());
                    $('#end_date').datepicker('setStartDate', minDate);

                });
                $("#end_date").datepicker()
                        .on('changeDate', function (selected) {
                            var minDate = new Date(selected.date.valueOf());
                            $('#start_date').datepicker('setEndDate', minDate);

                        });
            });
        </script>
        <script>
            $( document ).ready(function() {
                $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                    checkboxClass: 'icheckbox_flat-blue',
                    radioClass: 'iradio_flat-blue'
                });
            });
        </script>
    @stop
