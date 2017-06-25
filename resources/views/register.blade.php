<!DOCTYPE html>
<html>
<head>
@include('layout/head')
</head>
<body>
<nav class="navbar navbar-default">
	<h2><a class="navbar-brand" href="/">Loja de Música</a></h2>
</nav>
<div class="container">
	<form class="form-horizontal" action="/create" method="POST">
	  <div class="form-group">
	    <label for="name" class="col-sm-2 control-label">Name</label>
	    <div class="col-sm-10">
	      <input type="text" class="form-control" id="user" name='name' placeholder="Name" required="true">
	    </div>
	  </div>
	   <div class="form-group">
	    <label for="password" class="col-sm-2 control-label">Password</label>
	    <div class="col-sm-10">
	      <input type="password" class="form-control" id="password" name="password" placeholder="Password" min="3" required="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="email" class="col-sm-2 control-label">E-mail</label>
	    <div class="col-sm-10">
	      <input type="email" class="form-control" id="email" name='email' placeholder="E-mail" required="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="Age" class="col-sm-2 control-label">Age</label>
	    <div class="col-sm-10">
	      <input type="number" class="form-control" id="email" name='age' placeholder="Age" required="true">
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