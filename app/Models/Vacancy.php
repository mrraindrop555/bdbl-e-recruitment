<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
}
