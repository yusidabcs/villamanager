<div class="box-body">
	<div class="row">
		<div class="col-md-8">
			
			<div id='calendar' data-delete="{{ route('admin.villamanager.rate.index') }}"></div>

		</div>
		<div class="col-md-4">
			<a href="{{ route('admin.villamanager.villa.edit', [$villa->id]) }}" class="btn btn-success pull-right">Back to Villa</a>
			<div class="well" style="margin-top: 60px">
				{!! Form::open(['url' => route('admin.villamanager.rate.store',$villa->id) , 'id' => 'room-rate', 'class' => 'form']) !!}
				<form class="form-control" id="room-rate" ac>
					 <div class='form-group'>
			            <label>Start Date</label>
						 <div class="input-group date" id="start_date"  data-date-format="yyyy-mm-dd"
						 data-date-autoclose="true" >
							 <input type="text" class="form-control" name="start_date" readonly="">
							 <div class="input-group-addon">
								 <span class="glyphicon glyphicon-th"></span>
							 </div>
						 </div>
			        </div>
			        <div class='form-group'>
			            <label>End Date</label>
						<div class="input-group date" id="end_date"  data-date-format="yyyy-mm-dd"
							 data-date-autoclose="true" >
							<input type="text" class="form-control" name="end_date" readonly="">
							<div class="input-group-addon">
								<span class="glyphicon glyphicon-th"></span>
							</div>
						</div>
			        </div>

			        <div class='form-group'>
			            <label>Rate Name</label>
			            <input type="text" class="form-control" name="name" required="" placeholder="ex: Low Season rate">
			        </div>

			        <div class='form-group'>
			            <label>Rate</label>
			            <input type="number" min="0" class="form-control" name="rate" required="" placeholder="1000">
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
