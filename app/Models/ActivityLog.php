<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'event',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    /**
     * Get the subject of the activity (the model that was changed)
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the causer (usually the user who made the change)
     */
    public function causer(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the user who performed this activity
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get old values from properties
     */
    public function getOldAttribute(): ?array
    {
        return $this->properties['old'] ?? null;
    }

    /**
     * Get new values from properties
     */
    public function getNewAttribute(): ?array
    {
        return $this->properties['attributes'] ?? null;
    }

    /**
     * Log an activity
     */
    public static function logActivity(
        Model $subject,
        string $event,
        string $description = null,
        array $properties = []
    ): self {
        $user = auth()->user();

        return static::create([
            'user_id' => $user?->id,
            'log_name' => strtolower(class_basename($subject)),
            'description' => $description ?? ucfirst($event) . ' ' . class_basename($subject),
            'subject_type' => get_class($subject),
            'subject_id' => $subject->getKey(),
            'causer_type' => $user ? get_class($user) : null,
            'causer_id' => $user?->id,
            'properties' => $properties,
            'event' => $event,
        ]);
    }

    /**
     * Scope for filtering by log name
     */
    public function scopeForLog($query, string $logName)
    {
        return $query->where('log_name', $logName);
    }

    /**
     * Scope for filtering by subject
     */
    public function scopeForSubject($query, Model $subject)
    {
        return $query->where('subject_type', get_class($subject))
                     ->where('subject_id', $subject->getKey());
    }
}
