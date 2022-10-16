<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return CommentResource
     */
    public function index(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $comments = Comment::query()->paginate($pageSize);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CommentResouce
     */
    public function store(Request $request)
    {
        $created = Comment::query()->create([
            'body' => $request->body,
        ]);

        return new CommentResource($created);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return CommentResource
     */
    public function show(Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Comment  $comment
     * @return CommentResource | JsonResponse
     */
    public function update(Request $request, Comment $comment)
    {
        $updated = $comment->update([
            'body' => $request->body ?? $comment->body,
        ]);
        if (!$updated){
            return new JsonResponse([
                'errors' => [
                    'Faild to update model.',
                ]
            ], 400);
        }

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $deleted = $comment->forceDelete();
        if (!$deleted){
            return new JsonResponse([
                'errors' => [
                    'Could not delete resouce.',
                ]
            ],400);
        }

        return new JsonResponse([
            'data' => 'success',
        ]);
    }
}
