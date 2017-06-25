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
	<form class="form-horizontal" action="/login" method="POST">
	  <div class="form-group">
	    <label for="email" class="col-sm-2 control-label">E-mail</label>
	    <div class="col-sm-10">
	      <input type="email" class="form-control" id="email" name="email" placeholder="User" required="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <label for="password" class="col-sm-2 control-label">Password</label>
	    <div class="col-sm-10">
	      <input type="password" class="form-control" id="password" name="password" placeholder="Password" required="true">
	    </div>
	  </div>
	  <div class="form-group">
	    <div class="col-sm-offset-2 col-sm-10">
	      <button type="submit" class="btn btn-default">Submit</button>
	    </div>
	    <br /><br />
	    <a class="col-sm-offset-2 col-sm-10" href="/register">Cadastre-se</a>
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