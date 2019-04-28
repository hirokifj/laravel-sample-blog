<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $guarded = ['id'];

    protected $attributes = [
        'thumbnail_img' => ''
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(PostTag::class);
    }

    /**
     * カテゴリーでの絞り込み
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterCat($query, $categoryId)
    {
        if(!is_null($categoryId)) {
            return $query->where('category_id', $categoryId);
        }

        return $query;
    }

    /**
     * 記事タイトルでの絞り込み
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $word
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterTitle($query, $word)
    {
        if(!is_null($word)) {
            return $query->where('title', 'like', '%' . $word . '%');
        }

        return $query;
    }

    /**
     * 投稿日時でのソート
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $sort
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortDate($query, $sort = 'latest')
    {
        if($sort === 'oldest') {
            return $query->oldest();
        } else {
            return $query->latest();
        }
    }

    /**
     * コメントを新規追加
     *
     * @param array $comment POSTされたパラメータ
     * @return void
     */
    public function addComment($comment)
    {
        $this->comments()->create($comment);
    }

    /**
     * 記事が当該タグと関連付いていれば、trueを返す
     *
     * @param int $tagId タグのID
     * @return boolean
     */
    public function hasTag($tagId)
    {
        return DB::table('post_post_tag')->where([
            'post_id' => $this->id,
            'post_tag_id' => $tagId
        ])->exists();
    }
}
