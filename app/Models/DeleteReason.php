<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeleteReason extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'delete_reason';

    protected $fillable = [
        'deleted_user_id',
        'deleted_user_email',
        'deleted_user_name',
        'deleted_by_user_id',
        'deleted_by_user_email',
        'deleted_by_user_name',
        'reason',
        'deleted_at',
    ];

    protected $dates = ['deleted_at'];

    public function deletedByUser()
    {
        return $this->belongsTo(User::class, 'deleted_by_user_id');
    }
}
