<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vacancy extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'employment_type' => 'array',
            'qualifications' => 'array',
            'salary_and_benefits' => 'array'
        ];
    }

    public function attachment(): HasOne
    {
        return $this->hasOne(Attachment::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($vacancy) {
            $vacancy->attachment?->delete();
        });
    }
}
