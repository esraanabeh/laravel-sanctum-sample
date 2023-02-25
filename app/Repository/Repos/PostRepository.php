<?php

namespace App\Repository\Repos;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Support\Facades\Log;
use DB;
use Auth;

class PostRepository {

    public function allPosts()
    {
        $post= Post::whereUserId(Auth::user()->id)->latest()->paginate(10);
        return [
            'data'            =>  PostResource::collection($post),
            'status'          => true,
            'identifier_code' => 112001,
            'status_code'     => 200,
            'message'         => 'post listed successfully'
        ];
    }


    public function storePost($request){
    try{
        $post = Post::create([
            'user_id' => Auth::user()->id,
            'title' => $request->title,
            'topic' => $request->topic,
        ]);
        return [
            'data'            => new PostResource($post),
            'status'          => true,
            'identifier_code' => 113001,
            'status_code'     => 200,
            'message'         => 'post created successfully'
        ];
    }
    catch(\Exception $ex)
    {
        // rollback!!!
        DB::rollback();
            Log::info("create post exception due to =>".$ex->getMessage());
            return [
                'data'            => NULL,
                'status'          => false,
                'identifier_code' => 113002,
                'status_code'     => 400,
                'message'         => 'Some thing went wrong, please try again later'
            ];
    }

    }


    public function postDetails($id){
        $post=Post::whereId($id)->whereUserId(Auth::user()->id)->first();
        if($post){
            return [
                'data'            => new PostResource($post),
                'status'          => true,
                'identifier_code' => 114001,
                'status_code'     => 200,
                'message'         => 'post listed successfully'
            ];

        }
        else{
            return [
                'data'            => null,
                'status'          => false,
                'identifier_code' => 114001,
                'status_code'     => 400,
                'message'         => 'this post does not exist in your tasks'
            ];

        }
    }


    public function updatePost($request,$id){
        try {
        $post=Post::whereId($id)->whereUserId(Auth::user()->id)->first();
        if($post) {
            $post->update($request->all());
            return [
                'data'            => new PostResource($post),
                'status'          => true,
                'identifier_code' => 114001,
                'status_code'     => 200,
                'message'         => 'post listed successfully'
            ];
        }
        else{
            return [
                'data'            => null,
                'status'          => false,
                'identifier_code' => 114002,
                'status_code'     => 400,
                'message'         => 'this post does not exist in your tasks'
            ];
        }
    }
    catch(\Exception $ex)
    {
        // rollback!!!
        DB::rollback();
            Log::info("update post exception due to =>".$ex->getMessage());
            return [
                'data'            => NULL,
                'status'          => false,
                'identifier_code' => 114003,
                'status_code'     => 400,
                'message'         => 'Some thing went wrong, please try again later'
            ];
    }
    }


    public function destroyPost($id){
        $post=Post::whereId($id)->whereUserId(Auth::user()->id)->first();
        if($post){
            $post->delete();
            return [
                'data'            => null,
                'status'          => true,
                'identifier_code' => 115001,
                'status_code'     => 200,
                'message'         => 'post deleted successfully'
            ];
        }
        else{
            return [
                'data'            => null,
                'status'          => false,
                'identifier_code' => 115002,
                'status_code'     => 400,
                'message'         => 'this post does not exist in your tasks'
            ];
        }

    }
}
