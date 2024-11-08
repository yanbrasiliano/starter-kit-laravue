<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait LogsActivityTrait
{
  public function logUpdateActivity(string $activityName, Model $model, array $newData, string $description = 'Updated record')
  {
    $originalData = $model->toArray();
    $model->update($newData);
    $changes = [
      'before' => $originalData,
      'after' => $model->refresh()->toArray()
    ];

    activity($activityName)
      ->event('update')
      ->performedOn($model)
      ->causedBy(auth()->user())
      ->withProperties(['attributes' => $changes])
      ->log($description);
  }

  public function logDeleteActivity(string $activityName, Model $model, string $description = 'Deleted record')
  {
    activity($activityName)
      ->event('delete') 
      ->performedOn($model)
      ->causedBy(auth()->user())
      ->withProperties(['attributes' => ['before' => $model->toArray()]])
      ->log($description);

    $model->delete();
  }

  public function logGeneralActivity(string $activityName, Model $model, string $description, string $event = 'view')
  {
    activity($activityName)
      ->event($event)
      ->performedOn($model)
      ->causedBy(auth()->user())
      ->withProperties(['attributes' => $model->toArray()])
      ->log($description);
  }
}
