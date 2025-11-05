<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransactionLog extends Model
{
    use HasFactory;

    protected $table = 'transaction_logs';

    protected $fillable = [
        'order_id',
        'user_id',
        'donation_id',
        'gross_amount',
        'status',
        'is_anon',
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }
}
