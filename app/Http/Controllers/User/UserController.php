<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use App\Services\User\UserService;
use Illuminate\Http\{
    Request,
    Response,
};

class UserController extends Controller
{
    /**
     * UserInterface instance.
     *
     * @var \App\Interfaces\UserInterface $userInterface
     */
    protected UserInterface $userInterface;

    /**
     * UserService instance.
     *
     * @var \App\Services\User\UserService $userService
     */
    protected UserService $userService;

    /**
     * Setup the controller.
     *
     * @param \App\Services\User\UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Get the authenticate user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getAuthUser(Request $request): Response
    {
        return response([
            'success' => true,
            'user' => $request->user(),
        ])->setStatusCode(Response::HTTP_OK);
    }

    /**
     * Get the user stats.
     * Includes number of posts, followers, and following.
     *
     * @param int $id The user's id (users.id)
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserStats(int $id): Response
    {
        $userStats = $this->userService->handleGetUserStats($id);

        return response([
            'success' => true,
            'user' => $userStats,
        ]);
    }
}
