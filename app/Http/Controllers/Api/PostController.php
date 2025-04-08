<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        try {
            $post = Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $request->user()->id,
            ]);
            return ApiResponseService::success(
                [
                    'post' => $post,
                ],
                'Post add successful',
                201
            );

        } catch (\Exception $e) {
            Log::error('User Data Error: ' . $e->getMessage());
            return ApiResponseService::error(
                'Failed to add post',
                500, null
            );
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
