<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'target_amount',
        'description',
        'category',
        'cover_image',
        'is_approved',
        'creator_id',
    ];

    public function creator()
    {       
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class, 'creator_id');
    }
}
