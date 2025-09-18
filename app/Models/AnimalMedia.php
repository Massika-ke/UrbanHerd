<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnimalMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_id', 'media_type', 'file_path', 'file_name',
        'mime_type', 'file_size', 'description', 'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function getUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
