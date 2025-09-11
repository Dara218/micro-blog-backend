<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Interfaces\PostInterface;
use App\Services\Common\LogService;
use App\Services\Post\PostService;
use Illuminate\Http\Response;

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
                'posts' => null,
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
                'posts' => null,
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
                'posts' => null,
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
