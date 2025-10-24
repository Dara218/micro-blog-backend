<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use App\Interfaces\LikeInterface;
use App\Services\Common\LogService;
use App\Services\Like\LikeService;
use Illuminate\Http\{
    Request,
    Response,
};
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    /**
     * LikeInterface instance.
     *
     * @var \App\Interfaces\LikeInterface $likeInterface
     */
    protected LikeInterface $likeInterface;

    /**
     * LikeService instance.
     *
     * @var \App\Services\Like\LikeService $likeService
     */
    protected LikeService $likeService;

    /**
     * Setup the controller.
     *
     * @param \App\Interfaces\LikeInterface $likeInterface
     * @param \App\Services\Like\LikeService $likeService
     */
    public function __construct(LikeInterface $likeInterface, LikeService $likeService)
    {
        $this->likeInterface = $likeInterface;
        $this->likeService = $likeService;
    }

    /**
     * Get like information by post ID and user ID.
     *
     * @param int $id The post ID
     * @param int $userId The user ID
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function getByIdAndUserId(int $id, int $userId)
    {
        try {
            $likeInfo = $this->likeInterface->getByUserIdAndPostId($id, $userId);

            return response([
                'success' => true,
                'data' => $likeInfo,
            ]);
        } catch (\Exception $error) {
            LogService::error('Error fetching like info.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'message' => 'Error fetching like info.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Handle like/unlike action for a post.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function likePost(Request $request)
    {
        DB::beginTransaction();

        try {
            $data = $request->only([
                'user_id',
                'likeable_id',
                'likeable_type',
            ]);

            $this->likeService->handleLikePost($data);

            DB::commit();

            return response([
                'success' => true,
            ]);
        } catch (\Exception $error) {
            DB::rollBack();

            LogService::error('Error liking the content.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'message' => 'Error liking the content.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
