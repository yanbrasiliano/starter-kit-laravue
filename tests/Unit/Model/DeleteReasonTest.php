<?php

namespace Tests\Unit\Model;

use App\Models\DeleteReason;

describe('DeleteReasonModel Test', function () {
    it('has correct fillable attributes', function () {
        $fillable = [
            'deleted_user_id',
            'deleted_user_email',
            'deleted_user_name',
            'deleted_by_user_id',
            'deleted_by_user_email',
            'deleted_by_user_name',
            'reason',
            'deleted_at',
        ];
        $deleteReason = new DeleteReason();

        expect($deleteReason->getFillable())->toEqual($fillable);
    });

    it('has correct table name', function () {
        $deleteReason = new DeleteReason();
        expect($deleteReason->getTable())->toBe('delete_reason');
    });

    it('has correct primary key', function () {
        $deleteReason = new DeleteReason();
        expect($deleteReason->getKeyName())->toBe('id');
    });

    it('does not use timestamps', function () {
        $deleteReason = new DeleteReason();
        expect($deleteReason->usesTimestamps())->toBe(false);
    });

    it('has correct model class name', function () {
        $deleteReason = new DeleteReason();
        expect($deleteReason::class)->toBe(DeleteReason::class);
    });

    it('has correct relationship with User', function () {
        $deleteReason = new DeleteReason();
        $relation = $deleteReason->deletedByUser();
        expect($relation)->toBeInstanceOf(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        expect($relation->getForeignKeyName())->toBe('deleted_by_user_id');
        expect($relation->getRelated()->getKeyName())->toBe('id');
    });
})->group('model');
