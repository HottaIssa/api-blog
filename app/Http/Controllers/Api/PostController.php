<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        if ($posts->isEmpty()) {
            $data = [
                'success' => false,
                'message' => 'No posts found'
            ];
            return response()->json($data, 404);
        }
        return response()->json($posts, 200);
    }

    public function show($post)
    {
        $post = Post::find($post);
        if (!$post) {
            $data = [
                'success' => false,
                'message' => 'Post not found'
            ];
            return response()->json($data, 404);
        }
        $data = [
            'success' => true,
            'message' => 'Post found successfully',
            'post' => $post,
        ];
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'category' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);
        if ($validator->fails()) {
            $data = [
                'success' => false,
                'message' => 'Validation data error',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }
        $post = Post::create($validator->validated());
        $data = [
            'success' => true,
            'message' => 'Post created successfully',
            'post' => $post,
        ];
        return response()->json($data, 201);
    }

    public function update(Request $request, $post)
    {
        $post = Post::find($post);

        if (!$post) {
            $data = [
                'success' => false,
                'message' => 'Post not found'
            ];
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'category' => 'required|string|max:255',
            'content' => 'required|string|max:1000',
        ]);
        if ($validator->fails()) {
            $data = [
                'success' => false,
                'message' => 'Validation data error',
                'errors' => $validator->errors()
            ];
            return response()->json($data, 400);
        }

        $post->title = $request->title;
        $post->category = $request->category;
        $post->content = $request->content;
        $post->save();

        $data = [
            'success' => true,
            'message' => 'Post udpated successfully',
            'post' => $post,
        ];
        return response()->json($data, 201);
    }

    public function destroy($post)
    {
        $post = Post::find($post);
        if (!$post) {
            $data = [
                'success' => false,
                'message' => 'Post not found'
            ];
            return response()->json($data, 404);
        }
        $post->delete();
        $data = [
            'success' => true,
            'message' => 'Post deleted successfully'
        ];
        return response()->json($data, 200);
    }
}
