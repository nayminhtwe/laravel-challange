<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function list()
    {
        return PostResource::collection(Post::all());
    }

    public function toggleReaction(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'post_id' => 'required|int|exists:posts,id',
            'like'   => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 500,
                'message' => $validator->messages()->first(),
            ]);
        };

        $post = Post::find($request->post_id);

        if ($post->user_id == auth()->id()) {
            return response()->json([
                'status' => 500,
                'message' => 'You cannot like your post'
            ]);
        }

        $like = Like::where('post_id', $request->post_id)->where('user_id', auth()->id())->first();
        if (!!$like) {
            if ($request->like) {
                return response()->json([
                    'status' => 500,
                    'message' => 'You already liked this post'
                ]);
            } elseif (!$request->like) {
                $like->delete();

                return response()->json([
                    'status' => 200,
                    'message' => 'You unlike this post successfully'
                ]);
            }
        } else {
            if ($request->like) {
                Like::create([
                    'post_id' => $request->post_id,
                    'user_id' => auth()->id()
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'You like this post successfully'
                ]);
            } elseif (!$request->like) {

                return response()->json([
                    'status' => 500,
                    'message' => 'You have not liked this post yet'
                ]);
            }
        }
    }
}
