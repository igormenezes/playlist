<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Musics;
use App\Model\Favorites;

class FavoritesController extends Controller
{
    public function index(Request $request){
    	if(!$request->session()->get('login') && $request->session()->get('administrator') !== 0){
    	   return redirect('/');
    	}

    	$musics = DB::table('musics')
    	->select('musics.*')
    	->leftJoin('favorites', 'musics.id', '=', 'favorites.id_music')
    	->whereRaw('favorites.id_user IS NULL OR favorites.id_user <> ?', array($request->session()->get('login')))
    	->get();

    	return view('list', ['musics' => $musics]);
    }

    public function add(Request $request, Favorites $favorites, $id){
    	if(!is_numeric($id) || !$request->session()->get('login')){
    		return redirect('/');
    	}

    	$music = Musics::where('id', '=', $id)->first();

    	$favorites->id_user = $request->session()->get('login');
    	$favorites->id_music = $music->id;
    	$favorites->name = $music->name;
    	$favorites->style = $music->style;
    	$favorites->artist = $music->artist;

        $favorites->save();

        return redirect('/list');
    }

    public function favorites(Request $request){
    	if(!$request->session()->get('login') && $request->session()->get('administrator') !== 0){
    	   return redirect('/');
    	}

    	$favorites = Favorites::select()->where('id_user', '=', $request->session()->get('login'))->get();
    	return view('favorites', ['favorites' => $favorites]);
    }

    public function remove(Request $request, Favorites $favorites, $id){
    	if(!is_numeric($id) || !$request->session()->get('login')){
    		return redirect('/');
    	}

    	$favorites = Favorites::find($id);
		$favorites->delete();

        return redirect('/favorites');
    }

    public function find(Request $request){
    	if(empty($request->session()->get('login'))){
    		return redirect('/');
    	}

    	$search = '%' . $request->search;

    	$musics = DB::table('musics')
    	->select('musics.*')
    	->leftJoin('favorites', 'musics.id', '=', 'favorites.id_music')
    	->whereRaw('(favorites.id_user IS NULL OR favorites.id_user <> ?) AND (musics.style LIKE ? OR musics.artist LIKE ?)', array($request->session()->get('login'), $search, $search))
    	->get();

    	if($musics->count()){
    		return view('list', ['musics' => $musics]);
    	}

    	$musics = DB::table('musics')
    	->select('musics.*')
    	->leftJoin('favorites', 'musics.id', '=', 'favorites.id_music')
    	->whereRaw('favorites.id_user IS NULL OR favorites.id_user <> ?', array($request->session()->get('login')))
    	->get();

    	return view('list', ['musics' => $musics, 'message' => 'Não foi encontrado nenhum Artista ou Estilo, de acordo com sua busca']);	
    }

    public function quit(Request $request){
        $request->session()->forget('login');
        $request->session()->forget('administrator');
        return redirect('/');
    }
}
