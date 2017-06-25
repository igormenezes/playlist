<!DOCTYPE html>
<html>
<head>
@include('layout/head')
</head>
<body>
@include('layout/menu-favorites')
<div class="container">
  <h2>Your Favorites</h2>
  <p>Lista de suas músicas favoritas, sua playlist.</p>            
  <table class="table table-bordered">
    <thead id='title-favorites'>
      <tr>
        <th>Music</th>
        <th>Style</th>
        <th>Artist</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody id='favorites-musics'>
    @if(!empty($favorites))
	    @foreach ($favorites as $val)
			<tr>
		        <td>{{$val->name}}</td>
		        <td>{{$val->style}}</td>
		        <td>{{$val->artist}}</td>
		        <td><a href='remove/{{$val->id}}'>Remove</a></td>
	        </tr>
	    @endforeach
	@endif    
    </tbody>
  </table>
</div>
</body>
</html>