<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Attachment extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['src'];

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function getSrcAttribute()
    {
        return asset("storage/{$this->filename}");
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($attachment) {
            Storage::disk('public')->delete($attachment->filename);
        });
    }
}
