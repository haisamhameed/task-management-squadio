<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ApiResponseTrait;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\CommentResource;
use App\Repositories\CommentRepository;
use App\Http\Requests\Comment\StoreRequest;
use App\Http\Requests\Comment\UpdateRequest;
use App\Repositories\CommentRepositoryInterface;

class CommentController extends Controller
{
    use ApiResponseTrait;
    private CommentRepository $commentRepository;

    public function __construct(CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function index()
    {
        $comments = $this->commentRepository->getAllComments();
        return $this->successResponse('Comments retrieved successfully', [
            'tasks' => CommentResource::collection($comments),
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $comment = $this->commentRepository->createComment($data);
        return $this->successResponse('Comment added successfully', [
            'task' => new CommentResource($comment),
        ], 201);
    }

    public function update(UpdateRequest $request, $id) {
        $data = $request->validated();
        $comment = $this->commentRepository->getCommentById($id);
        if (!$comment) {
            return $this->errorResponse('Comment not found', 404);
        }
        Gate::authorize('update', $comment);
        $this->commentRepository->updateComment($id, $data);
        $comment->refresh();
        return $this->successResponse('Comment updated successfully', [
            'task' => new CommentResource($comment),
        ]);
    }

    public function destroy($id)
    {
        $comment = $this->commentRepository->getCommentById($id);
        if (!$comment) {
            return $this->errorResponse('Comment not found', 404);
        }
        Gate::authorize('delete', $comment);
        $this->commentRepository->deleteComment($id);
        return $this->successResponse('Comment deleted successfully');
    }
}
