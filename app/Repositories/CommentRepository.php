<?php 

namespace App\Repositories;

use App\Exceptions\GeneralJsonException;
use App\Models\Comment;
use Illuminate\Support\Facades\DB;

class CommentRepository extends BaseRepository
{
  public function create(array $attributes)
  {
    return DB::transaction(function() use ($attributes){
      $created = Comment::query()->create([
        'body' => data_get($attributes, 'body'),
      ]);
      throw_if(!$created, GeneralJsonException::class, 'Failed to create comment.');
      if ($userIds = data_get($attributes, 'user_ids')){
        $created->users()->sync($userIds);
      }
      if ($postIds = data_get($attributes, 'post_ids')){
        $created->posts()->sync($postIds);
      }

      return $created;
    });
  }

  public function update($comment, array $attributes)
  {
    return DB::transaction(function() use($comment, $attributes){
      $updated = $comment->update([
        'body' => data_get($attributes, 'body'),
      ]);
      throw_if(!$updated, GeneralJsonException::class, 'Failed to update comment');
    });

    return $comment;
  }


  public function forceDelete($comment)
  {
    return DB::transaction(function() use($comment){
      $deleted = $comment->forceDelete();
      throw_if(!$deleted, GeneralJsonException::class, 'Could not delete comment.');

      return $deleted;
    });
  }
}