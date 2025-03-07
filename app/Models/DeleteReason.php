<?php

declare(strict_types = 1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @template TFactory of \Illuminate\Database\Eloquent\Factories\Factory
 */
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

    /**
     * @var array<int, string>
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the user who deleted.
     *
     * @return BelongsTo
     */
    public function deletedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'deleted_by_user_id');
    }
}
