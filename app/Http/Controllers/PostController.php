<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Validator;
use App\Http\Resources\Post as PostResources;
use App\Http\Controllers\BaseController as BaseController;
class PostController extends Controller
{
    public function index()     // posts show
    {
        $posts = Post::all();
        return response()->json(PostResources::collection($posts));
    }


    public function store(Request $request)    //post create
    {
        $input = $request->all();
        $validator = Validator::make($input , [
            'title' => 'required',
            'content' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json("an error accoured");
        }
        $post = Post::create($input);
        return response()->json("post created successfully");
    }

    public function destroy($id)    //post delete
    {
        $post = Post::find($id);
        if (is_null($post))
            return BaseController::sendError( 'invalid input');

        $post->delete();
        return BaseController::sendResponse(new PostResources($post), 'post deleted successfully');
    }
}
