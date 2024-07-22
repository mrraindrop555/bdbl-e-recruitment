<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ApplicationFile extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = ['src'];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function getSrcAttribute()
    {
        return asset("storage/{$this->filename}");
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($file) {
            Storage::disk('public')->delete($file->filename);
        });
    }
}
