<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;

class Application extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'class_x_marks' => 'array',
            'class_xii_marks' => 'array'
        ];
    }

    public function vacancy(): BelongsTo
    {
        return $this->belongsTo(Vacancy::class);
    }

    public function applicationFiles(): HasMany
    {
        return $this->hasMany(ApplicationFile::class);
    }

    public static function boot()
    {
        parent::boot();
        self::deleting(function ($application) {
            $application->passportPhoto?->delete();
            $application->classXMarksheet?->delete();
            $application->classXIIMarksheet?->delete();
            $application->universityOrCollegeMarksheet?->delete();
            $application->mastersMarksheet?->delete();
            $application->citizenshipIdentityCard?->delete();
            $application->securityClearanceCertificate?->delete();
            $application->medicalCertificate?->delete();
            $application->cv?->delete();
            $application->noc?->delete();
        });
    }
}
