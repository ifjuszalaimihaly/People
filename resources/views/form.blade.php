@extends('master')
@section('title')
Személy felvétele, módosítása
@endsection
@section('content')
	<div class="col-md-6 col-sm-8 col-xs-12">
			<form 
			method="post"
			enctype="multipart/form-data"
			@if(isset($updatedperson))
				action="{{ route('person.update', $updatedperson->id) }}" 		  
			@else
				action="{{ route('person.store') }}" 	
			@endif
			>
		 	@if(isset($updatedperson))
		 	{{ method_field("PUT") }} 
		 	<input type="hidden" name="personid" value="{{$updatedperson->id}}">
		 	@else
			<input type="hidden" name="personid" value="0">
			@endif		 	
				{{ csrf_field() }}
				<div class="form-group">
					<label>Felettes</label>
					<select name="boss_id" class="form-control"
						@isset ($updatedperson)
						    disabled="disabled" 
						@endisset
						>
							@if (isset($updatedperson))
								@if($updatedperson->boss_id !=0)
								<option>{{$updatedperson->boss->first_name}} {{ $updatedperson->boss->last_name}}</option>
								@endif

							@else
								<option value="0"></option>
								@if (count($people) > 0)
								@foreach($people as $person)
									<option value="{{$person->id}}">{{$person->last_name}} {{$person->first_name}}</option>
								@endforeach
								@endif
							@endif
						
					</select>
				</div>
				<div class="form-group">
					<label>Vezetéknév</label>
					<input name="last_name" type="text" class="form-control"  
					@if (isset($updatedperson))
						value="{{$updatedperson->last_name}}"
					@endif
					@if (old('last_name',null)!=null)
						value="{{old('last_name')}}"
					@endif
					required="required" 
					>
				</div>
				<div class="form-group">
					<label>Keresztnév</label>
					<input name="first_name" type="text" class="form-control"  
					@if (isset($updatedperson))
						value="{{$updatedperson->first_name}}"
					@endif
					@if (old('first_name',null)!=null)
						value="{{old('first_name')}}"
					@endif
					required="required" >
				</div>
				<div class="form-group">
					<label>Email</label>
					<input name="email" type="email" class="form-control"
					@if (isset($updatedperson))
						value="{{$updatedperson->email}}"
					@endif
					@if (old('email',null)!=null)
						value="{{old('email')}}"
					@endif
					required="required" >
					
				</div>
				<div class="form-group">
					<label>Honlap</label>
					<input name="website" type="text" class="form-control" 
					@if (isset($updatedperson))
						value="{{$updatedperson->website}}"
					@endif
					@if (old('website',null)!=null)
						value="{{old('website')}}"
					@endif
					>
				</div>
				<div class="form-group">
					<label>Telefonszám</label>
					<input name="phone" type="phone" class="form-control" 
					@if (isset($updatedperson))
						value="{{$updatedperson->phone}}"
					@endif
					@if (old('phone',null)!=null)
						value="{{old('phone')}}"
					@endif
					required="required" >
				</div>
				<div class="form-group">
					<label>Fénykép</label>
					<label class="btn btn-default btn-file">Tallózás<input type="file" name="image" style="display: none;">
					</label>
				</div>
				<button type="submit" class="btn btn-default">Felvesz/Módosít</button>
			</form>
			@if(count($errors) > 0)
			<div class="alert alert-danger">
				<strong>A feltöltés nem sikerült</strong>
				<br><br>
				<ul>
					@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
					@endforeach
				</ul>
			</div>
			@endif
			@if(session()->has('message'))
			    <div class="alert alert-success">
			        {{ session()->get('message') }}
			    </div>
			@endif
	</div>
@endsection