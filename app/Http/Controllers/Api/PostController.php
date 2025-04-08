<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Services\ApiResponseService;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $posts = Post::with('user')->paginate(5);
            return ApiResponseService::paginated(
                $posts,
                PostResource::class,
                'get all posts successfully',
                200
            );
        } catch (\Exception $e) {
            Log::error('User Data Error: ' . $e->getMessage());
            return ApiResponseService::error(
                'Failed to get all posts',
                500,
                null
            );
        }
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
                    'post' => PostResource::make($post),
                ],
                'Post add successful',
                201
            );
        } catch (\Exception $e) {
            Log::error('User Data Error: ' . $e->getMessage());
            return ApiResponseService::error(
                'Failed to add post',
                500,
                null
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            // Load any necessary relationships
            $post = Post::with('user')->find($id);

            if (!$post) {
                return ApiResponseService::error(
                    'Post not found',
                    404
                );
            }

            return ApiResponseService::success(
                ['post' => PostResource::make($post)],
                'Post retrieved successfully',
                200
            );
        } catch (\Exception $e) {
            Log::error('Post Show Error: ' . $e->getMessage());
            return ApiResponseService::error(
                'Failed to retrieve post',
                500
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, $id)
    {
        try {
            $post = Post::with('user')->find($id);
            if (!$post) {
                return ApiResponseService::error(
                    'Post not found',
                    404
                );
            }

            if ($post->user_id !== $request->user()->id) {
                return ApiResponseService::error(
                    'Unauthorized: You can only update your own posts',
                    403
                );
            }

            $post->update($request->validated());
            return ApiResponseService::success(
                ['post' => PostResource::make($post)],
                'Post updated successfully',
                200
            );
        } catch (\Exception $e) {
            Log::error('Post Update Error: ' . $e->getMessage());
            return ApiResponseService::error(
                'Failed to update post',
                500
            );
        }
    }

    /**
     * Remove the specified post from storage.
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);
            if (!$post) {
                return ApiResponseService::error(
                    'Post not found',
                    404
                );
            }

            if ($post->user_id !== auth()->user()->id) {
                return ApiResponseService::error(
                    'Unauthorized: You can only delete your own posts',
                    403
                );
            }
            $post->delete();

            return ApiResponseService::success(
                null,
                'Post deleted successfully',
                200
            );
        } catch (\Exception $e) {
            Log::error('Post Delete Error: ' . $e->getMessage());
            return ApiResponseService::error(
                'Failed to delete post',
                500
            );
        }
    }
}
