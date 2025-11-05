<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'raised_percent,'
    ];

    public function creator()
    {       
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function transactionLogs()
    {
        return $this->hasMany(TransactionLog::class, 'donation_id', 'id');
    }

    public function getAmountRaisedAttribute($value)
    {
        return $value ?? $this->transactionLogs()->where('status', 'success')->sum('gross_amount');
    }
    
    public function getRaisedPercentageAttribute()
    {
        $target = $this->target_amount;
        $raised = $this->amount_raised; // ini memanggil accessor sebelumnya

        if (!$target || $target == 0) {
            return 0; // hindari pembagian dengan nol
        }

        return round(($raised / $target) * 100, 2); // 2 desimal
    }
}
