<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    /**
     * Boot the trait
     */
    public static function bootLogsActivity(): void
    {
        // Log when model is created
        static::created(function ($model) {
            ActivityLog::logActivity(
                $model,
                'created',
                'Data ' . class_basename($model) . ' dibuat',
                ['attributes' => $model->getAttributes()]
            );
        });

        // Log when model is updated
        static::updated(function ($model) {
            $changes = $model->getChanges();
            $original = [];
            
            foreach (array_keys($changes) as $key) {
                if ($key !== 'updated_at') {
                    $original[$key] = $model->getOriginal($key);
                }
            }
            
            // Remove updated_at from changes
            unset($changes['updated_at']);
            
            if (!empty($changes)) {
                ActivityLog::logActivity(
                    $model,
                    'updated',
                    'Data ' . class_basename($model) . ' diperbarui',
                    [
                        'old' => $original,
                        'attributes' => $changes
                    ]
                );
            }
        });

        // Log when model is deleted
        static::deleted(function ($model) {
            ActivityLog::logActivity(
                $model,
                'deleted',
                'Data ' . class_basename($model) . ' dihapus',
                ['old' => $model->getAttributes()]
            );
        });
    }

    /**
     * Get all activities for this model
     */
    public function activities()
    {
        return ActivityLog::forSubject($this)->latest()->get();
    }
}
