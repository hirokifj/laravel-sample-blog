<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = ['id'];

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

    /**
     * カテゴリーでの絞り込み
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int|null $categoryId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchCat($query, $categoryId)
    {
        if(!is_null($categoryId)) {
            return $query->where('category_id', $categoryId);
        }

        return $query;
    }

    /**
     * 記事タイトルで検索
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $word
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearchTitle($query, $word)
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
}
