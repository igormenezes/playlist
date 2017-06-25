<nav class="navbar navbar-default">
  <h2><a class="navbar-brand" href="/">Loja de Música</a></h2>
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <form class="navbar-form navbar-left" action="/find" method="POST">
          <div class="form-group">
            <input type="text" name='search' class="form-control" placeholder="Search">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">  
          </div>
          <button type="submit" class="btn btn-default">Search</button>
        </form>
        <li> <a href="/favorites">My Favorites</a></li>
      	<li> <a href="/list">List Musics</a></li>
        <li><a href="/quit">Exit</a></li>
      </ul>
    </div>
  </div>
</nav>