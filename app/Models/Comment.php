<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    use HasFactory;

    public const STATUS_SELECT = [
        'new'       => 'Новый',
        'in_work'   => 'В работе',
        'published' => 'Опубликованный',
    ];

    public $table = 'comments';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'text',
        'video_id',
        'status',
        'user_email',
        'answer_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function answerComments()
    {
        return $this->hasMany(Comment::class, 'answer_id', 'id');
    }

    public function video()
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    public function answer()
    {
        return $this->belongsTo(Comment::class, 'answer_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
