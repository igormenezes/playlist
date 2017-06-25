<!DOCTYPE html>
<html>
<head>
@include('layout/head')
</head>
<body>
@include('layout/menu-favorites')
<div class="container">
  @if (!empty($message)) 
  	<div class="alert alert-danger">{{ $message }}</div>
  @endif	
  <h2>Musics List</h2>
  <p>Lista de músicas disponíveis que NÂO foram adicionadas na sua playlist (favoritos).</p>            
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
    @if(!empty($musics))
	    @foreach ($musics as $val)
			<tr>
		        <td>{{$val->name}}</td>
		        <td>{{$val->style}}</td>
		        <td>{{$val->artist}}</td>
		        <td><a href='add/{{$val->id}}'>Add Favorites</a></td>
	        </tr>
	    @endforeach
	@endif    
    </tbody>
  </table>
</div>
</body>
</html>