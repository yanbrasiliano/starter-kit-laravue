<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait LogsActivityTrait
{
  /**
   * Logs an update activity.
   *
   * @param string $activityName
   * @param Model $model
   * @param array<string, mixed> $newData
   * @param string $description
   * @return void
   */
  public function logUpdateActivity(string $activityName, Model $model, array $newData, string $description = 'Updated record'): void
  {
    $originalData = $model->toArray();
    $changes = [
      'before' => $originalData,
      'after' => $model->refresh()->toArray(),
    ];

    activity($activityName)
      ->event('update')
      ->performedOn($model)
      ->causedBy(auth()->user())
      ->withProperties(['attributes' => $changes])
      ->log($description);
  }

  /**
   * Logs a delete activity.
   *
   * @param string $activityName
   * @param Model $model
   * @param string $description
   * @return void
   */
  public function logDeleteActivity(string $activityName, Model $model, string $description = 'Deleted record'): void
  {
    activity($activityName)
      ->event('delete')
      ->performedOn($model)
      ->causedBy(auth()->user())
      ->withProperties(['attributes' => ['before' => $model->toArray()]])
      ->log($description);
  }

  /**
   * Logs a general activity.
   *
   * @param string $activityName
   * @param Model $model
   * @param string $description
   * @param string $event
   * @return void
   */
  public function logGeneralActivity(string $activityName, Model $model, string $description, string $event = 'view'): void
  {
    activity($activityName)
      ->event($event)
      ->performedOn($model)
      ->causedBy(auth()->user())
      ->withProperties(['attributes' => $model->toArray()])
      ->log($description);
  }
}
