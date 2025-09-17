<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\Post\CreatePostRequest;
use App\Interfaces\PostInterface;
use App\Services\Common\LogService;
use App\Services\Post\PostService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    /**
     * PostInterface instance.
     *
     * @var \App\Interfaces\PostInterface $postInterface
     */
    protected PostInterface $postInterface;

    /**
     * PostService instance.
     *
     * @var \App\Services\Post\PostService $postService
     */
    protected PostService $postService;

    /**
     * Setup the controller.
     *
     * @param \App\Interfaces\PostInterface $postInterface
     * @param \App\Services\Post\PostService $postService
     */
    public function __construct(PostInterface $postInterface, PostService $postService)
    {
        $this->postInterface = $postInterface;
        $this->postService = $postService;
    }

    /**
     * Get the posts of the user.
     *
     * @param int $id The user id (posts.user_id)
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserPosts(int $id): Response
    {
        try {
            $userPosts = $this->postInterface->getUserPost($id);

            return response([
                'success' => true,
                'posts' => $userPosts,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $error) {
            LogService::error('Error fetching user posts.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'message' => 'Error fetching post.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get the posts of the user's friends.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The user id (posts.user_id)
     *
     * @return \Illuminate\Http\Response
     */
    public function getFriendsPost(int $id): Response
    {
        try {
            $friendsPost = $this->postService->handleGetFriendPost($id);

            return response([
                'success' => true,
                'posts' => $friendsPost,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $error) {
            LogService::error('Error fetching user friends posts.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'message' => 'Error fetching post.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get all posts for the home page.
     * Includes authenticated user posts + friends posts.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id The user id (posts.user_id)
     *
     * @return \Illuminate\Http\Response
     */
    public function getHomePosts(int $id)
    {
        try {
            $allPosts = $this->postService->handleGetHomePosts($id);

            return response([
                'success' => true,
                'posts' => $allPosts,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $error) {
            LogService::error('Error fetching posts.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'message' => 'Error fetching posts.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a new post.
     *
     * @param \App\Http\Requests\Post\CreatePostRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePostRequest $request): Response
    {
        DB::beginTransaction();

        try {
            $post = $this->postInterface->create($request->all());

            DB::commit();

            return response([
                'success' => true,
                'post' => $post->load(['user', 'media']),
            ]);
        } catch (\Exception $error) {
            DB::rollBack();

            LogService::error('Error creating post.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'message' => 'Error creating post.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
