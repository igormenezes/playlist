<!DOCTYPE html>
<html>
<head>
@include('layout/head')
</head>
<body>
@include('layout/menu-admin')
<div class="container">
	<form class="form-horizontal" action="/save" method="POST">
	  <div class="form-group">
	    <label for="name" class="col-sm-2 control-label">Music Name</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="user" name='name' placeholder="Music Name" required="true">
	    </div>
	  </div>
	   <div class="form-group">
	    <label for="style" class="col-sm-2 control-label">Style</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="style" name="style" placeholder="Style" required="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="artist" class="col-sm-2 control-label">Artist</label>
	    <div class="col-sm-10">
	      <input type="artist" class="form-control" id="artist" name='artist' placeholder="Artist" required="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="submit" class="btn btn-default">Register</button>
	    </div>
	  </div>

	  @if (count($errors) > 0)
      <div class="alert alert-danger errors">
	      @foreach ($errors->all() as $error)
	      	<p>{{ $error }}</p>
	      @endforeach
      </div>
      @endif

      @if (!empty($message)) 
      	<div class="alert alert-danger">{{ $message }}</div>
      @endif	
        
      <input type="hidden" name="_token" value="{{ csrf_token() }}">  
	</form>
</div>
</body>
</html>