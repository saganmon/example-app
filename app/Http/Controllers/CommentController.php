<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::query()->get();

        return new JsonResponse([
            'data' => $comments,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $created = Comment::query()->create([
            'body' => $request->body,
        ]);

        return new JsonResponse([
            'data' => $created,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        return new JsonResponse([
            'data' => $comment,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
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

        return new JsonResponse([
            'data' => $comment,
        ]);
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
