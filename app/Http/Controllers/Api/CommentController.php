<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function postComment(Request $request, $id)
    {
        try {
            $post = Post::find($id);

            if (!$post) {
                $data = [
                    'success' => false,
                    'message' => 'Post not found'
                ];
                return response()->json($data, 404);
            }
            $validator = Validator::make($request->all(), [
                'comment' => 'required|string'
            ]);
            if ($validator->fails()) {
                $data = [
                    'success' => false,
                    'message' => 'Validation data error',
                    'errors' => $validator->errors()
                ];
                return response()->json($data, 400);
            }
            $comment = new Comment();
            $comment->post_id = $post->id;
            $comment->comment = $request->comment;
            $comment->user_id = Auth::user()->id;
            $comment->save();
            $data = [
                'success' => true,
                'message' => 'Comment created successfully',
            ];
            return response()->json($data, 201);
        } catch (\Exception $th) {
            $data = [
                'success' => false,
                'message' => $th->getMessage()
            ];
            return response()->json($data, 403);
        }
    }
}
