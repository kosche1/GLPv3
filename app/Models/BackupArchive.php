<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BackupArchive extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'original_path',
        'disk',
        'filename',
        'size',
        'backup_date',
        'archived_date',
        'archived_by',
        'notes',
        'metadata',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'backup_date' => 'datetime',
        'archived_date' => 'datetime',
        'metadata' => 'array',
    ];

    /**
     * Get the user who archived this backup.
     */
    public function archivedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'archived_by');
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedSizeAttribute(): string
    {
        return $this->size;
    }

    /**
     * Get the backup type from metadata.
     */
    public function getBackupTypeAttribute(): string
    {
        if (isset($this->metadata['type'])) {
            return $this->metadata['type'];
        }
        
        // Try to determine from filename
        if (str_contains($this->filename, 'db-only')) {
            return 'Database Only';
        } elseif (str_contains($this->filename, 'files-only')) {
            return 'Files Only';
        } else {
            return 'Full Backup';
        }
    }
}
