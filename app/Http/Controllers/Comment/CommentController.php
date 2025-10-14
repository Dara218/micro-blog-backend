<?php

namespace App\Http\Controllers\Comment;

use App\Http\Controllers\Controller;
use App\Interfaces\CommentInterface;
use App\Services\Common\LogService;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * CommentInterface instance.
     *
     * @var \App\Interfaces\CommentInterface $commentInterface
     */
    protected CommentInterface $commentInterface;

    /**
     * Setup the controller.
     *
     * @param \App\Interfaces\CommentInterface $commentInterface
     */
    public function __construct(CommentInterface $commentInterface)
    {
        $this->commentInterface = $commentInterface;
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
}
