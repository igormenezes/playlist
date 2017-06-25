<!DOCTYPE html>
<html>
<head>
@include('layout/head')

<script type="text/javascript">
	$(document).ready(function(){
		$('.search').click(function(){
			var attribute = $(this).attr('val');

			$.ajax({
				url: '/search',
				type: 'GET',
				dataType: 'json',
				data: {search: $(this).attr('val')},
			})
			.done(function(datas) {
				$('#title-favorites').html('');
				$('#favorites-musics').html('');

				html = '';
				html += '<tr>';
				html += '<th>Total</th>';
				html += '<th>'+attribute+'</th>';
				html += '</tr>';

				$('#title-favorites').append(html);

				$.each(datas, function( i, data ) {
					html = '';
					html += '<tr>';
					html += '<td>'+data.total+'</td>';
					html += '<td>'+data.val+'</td>';		
					html += '</tr>';

					$('#favorites-musics').append(html);
				});
			})
			.fail(function() {
				console.log("error");
			})
			.always(function() {
			});
			
		});
	});
</script>

</head>
<body>
@include('layout/menu-admin')
<div class="container">
  <h2>Rank Favorites</h2>
  <p>Clique em <a href='/rank' style="cursor: pointer" val='todos'>todos</a>, <a class="search" style="cursor: pointer" val='name'>music</a>, <a  class="search" style="cursor: pointer" val='style'>style</a> ou <a class="search" style="cursor: pointer" val='artist'>artist</a> e veja o rank de favoritos de cada categoria.</p>            
  <table class="table table-bordered">
    <thead id='title-favorites'>
      <tr>
        <th>Music</th>
        <th>Style</th>
        <th>Artist</th>
      </tr>
    </thead>
    <tbody id='favorites-musics'>
    @if(!empty($favorites))
	    @foreach ($favorites as $favorite)
			<tr>
		        <td>{{$favorite->name}}</td>
		        <td>{{$favorite->style}}</td>
		        <td>{{$favorite->artist}}</td>
	        </tr>
	    @endforeach
	@endif    
    </tbody>
  </table>
</div>
</body>
</html>