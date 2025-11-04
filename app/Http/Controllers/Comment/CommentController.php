<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Comment\CreateCommentRequest;
use App\Interfaces\CommentInterface;
use App\Services\Comment\CommentService;
use App\Services\Common\LogService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    /**
     * CommentInterface instance.
     *
     * @var \App\Interfaces\CommentInterface $commentInterface
     */
    protected CommentInterface $commentInterface;

    /**
     * CommentService instance.
     *
     * @var \App\Services\Comment\CommentService $commentService
     */
    protected CommentService $commentService;

    /**
     * Setup the controller.
     *
     * @param \App\Interfaces\CommentInterface $commentInterface
     * @param \App\Services\Comment\CommentService $commentService
     */
    public function __construct(CommentInterface $commentInterface, CommentService $commentService)
    {
        $this->commentInterface = $commentInterface;
        $this->commentService = $commentService;
    }

    /**
     * Get the comments of the comment by parent id.
     *
     * @param int $id The parent comment id (comments.parent_id)
     *
     * @return \Illuminate\Http\Response
     */
    public function getCommentByParentId(int $id): Response
    {
        try {
            $comments = $this->commentInterface->getCommentsByParentId($id);

            return response([
                'success' => true,
                'comments' => $comments,
            ])->setStatusCode(Response::HTTP_OK);
        } catch (\Exception $error) {
            LogService::error('Error fetching user comments.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'message' => 'Error fetching comments.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function createPost(CreateCommentRequest $request)
    {
        DB::beginTransaction();

        try {
            $comment = $this->commentInterface->create($request->validated())->load('user');

            // Increment the comment count on posts table
            $this->commentService->incrementCommentCount($comment->post_id);

            DB::commit();

            return response([
                'success' => true,
                'comment' => $comment,
            ]);
        } catch (\Exception $error) {
            DB::rollBack();

            LogService::error('Error creating a comment.', [
                'error' => $error->getMessage(),
                'trace' => $error->getTraceAsString(),
            ]);

            return response([
                'success' => false,
                'message' => 'Error creating a comment.',
            ])->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
