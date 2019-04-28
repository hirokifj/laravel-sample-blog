<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\CustomResetPassword;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'owner_id');
    }

    /**
     * 投稿の所有者であればtrueを返す
     *
     * @param  \App\Post  $post
     * @return boolean
     */
    protected function isOwner(Post $post)
    {
        return $this->id === $post->owner_id;
    }

    /**
     * 投稿を編集可能であればtrueを返す
     *
     * @param  \App\Post  $post
     * @return boolean
     */
    public function canEditPost(Post $post)
    {
        //投稿者自身であれば編集可能とする
        return $this->isOwner($post);
    }

    /**
     * パスワードリセットメールを日本語化
     * (通知クラスを変更する)
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }
}
