<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        //echo "in đếc";

        //lay du lieu
        //$posts = Post::orderBy('created_at', 'desc') -> paginate(10);
        $posts = Post::all();

        //render ra view
        return view('posts.index', ['posts' => $posts]);
        //dd($posts);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        echo "cờ re a te";
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        echo "sờ to";
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        echo "sâu";
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        echo "ê đýt";
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        echo "úp đết";
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        echo "đét choi";
    }
}
