<div class="box-body">
	<div class="row">
		<div class="col-md-8">
			
			<div id='calendar' data-delete="{{ route('admin.villamanager.rate.index') }}"></div>

		</div>
		<div class="col-md-4">
			<div class="well" style="margin-top: 72px">
				{!! Form::open(['url' => route('admin.villamanager.rate.store',$villa->id) , 'id' => 'room-rate', 'class' => 'form']) !!}
				<form class="form-control" id="room-rate" ac>

					 <div class='form-group {{ $errors->has('start_date') ? ' has-error' : '' }}'>
			            <label>Start Date</label>
						 <div class="input-group date" id="start_date"  data-date-format="yyyy-mm-dd"
						 data-date-autoclose="true" >
							 <input type="text" class="form-control" name="start_date" readonly="" required>
							 <div class="input-group-addon">
								 <span class="glyphicon glyphicon-th"></span>
							 </div>
						 </div>
						 {!! $errors->first('start_date', '<span class="help-block">:message</span>') !!}
			        </div>
			        <div class='form-group {{ $errors->has('end_date') ? ' has-error' : '' }}'>
			            <label>End Date</label>
						<div class="input-group date" id="end_date"  data-date-format="yyyy-mm-dd"
							 data-date-autoclose="true" >
							<input type="text" class="form-control" name="end_date" readonly="" required>
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
						{!! $errors->first('end_date', '<span class="help-block">:message</span>') !!}
			        </div>

			        <div class='form-group {{ $errors->has('name') ? ' has-error' : '' }}'>
			            <label>Rate Name</label>
			            <input type="text" class="form-control" name="name" required="">
						{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
			        </div>

			        <div class='form-group {{ $errors->has('rate') ? ' has-error' : '' }}'>
			            <label>Rate</label>
			            <input type="number" min="0" class="form-control" name="rate" required="">
						{!! $errors->first('rate', '<span class="help-block">:message</span>') !!}
			        </div>



			        <div class='form-group'>
			        	<input type="hidden" name="villa_id" value="{{ $villa->id }}">
			        	<input type="hidden" name="id" value="">
			            <button type="submit" class="btn btn-info">Save</button>
			        </div>
				</form>
			</div>
		</div>
	</div>
    
</div>
<script>
</script>
