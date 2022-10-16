<?php 

namespace App\Repositories;

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
      if (!$updated){
          return new \Exception('Failed to update comment');
      }
    });

    return $comment;
  }


  public function forceDelete($comment)
  {
    return DB::transaction(function() use($comment){
      $deleted = $comment->forceDelete();
      if (!$deleted){
          return new \Exception('Could not delete comment.');
      }

      return $deleted;
    });
  }
}