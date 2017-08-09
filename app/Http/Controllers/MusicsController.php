<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Musics;
use App\Model\Favorites;

class MusicsController extends Controller
{
    public function index(Request $request){
    	if($request->session()->get('login') && $request->session()->get('administrator') === 1){
    	   return view('music');
    	}

    	return redirect('/');
    }

    public function save(Request $request, Musics $musics){
    	$this->validate($request, [
        	'name' => ['required'],
        	'style' => ['required'],
        	'artist' => ['required']
    	]);	

    	$music_registered = Musics::where('name', '=', $request->name)
        ->where('style', '=', $request->style)
        ->where('artist', '=', $request->artist)
        ->first();

        if(empty($music_registered)){
            $musics->name = $request->name;
            $musics->style = $request->style;
            $musics->artist = $request->artist;

            $musics->save();

            return redirect('/music');
        }
            
        return view('music', ['message' => 'Essa música já foi cadastrada']);
    }

    public function rank(Request $request){
        if($request->session()->get('login') && $request->session()->get('administrator') === 1){
            $datas = DB::table('favorites')->select('name', 'style', 'artist')->get();
            return view('rank', ['favorites' => $datas]);
        }

        return redirect('/');
    }

    public function search(Request $request){
        switch ($request->search) {
            case 'name':
                $query1 = "COUNT(name) AS total, name AS val";
                $query2 = "COUNT(name) DESC";
                break;
            case 'style':
                $query1 = "COUNT(style) AS total, style AS val";
                $query2 = "COUNT(style) DESC";
                break;
            case 'artist':
                $query1 = "COUNT(artist) AS total, artist AS val";
                $query2 = "COUNT(artist) DESC";
                break;
            default:
                $datas = DB::table('favorites')->select('name', 'style', 'artist')->get();
                return(json_encode($datas)); 
        }

        $datas = DB::table('favorites')
            ->select(DB::raw($query1))
            ->groupBy($request->search)
            ->orderByRaw($query2)
            ->get();


        return(json_encode($datas));

    }

    public function exit(Request $request){
        $request->session()->forget('login');
        $request->session()->forget('administrator');
        return redirect('/');
    }
}