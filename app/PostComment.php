<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PostComment extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'owner_id' => 0 //未ログインユーザーの場合は、0を格納する。
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * コメントに紐づくユーザーが存在しているかを確認
     *
     * @return boolean
     */
    protected function isOwnerExists() {

        return DB::table('users')->where('id', $this->owner_id)->exists();
    }

    /**
     * コメンしたユーザーの、ユーザー名もしくはデフォルト値を返す
     *
     * @return string
     */
    public function ownerNameOrDefault() {

        return $this->isOwnerExists() ? $this->owner->name : config('post-comment.defaultOwnerName');
    }
}
