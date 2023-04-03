<?php

declare(strict_types=1);

namespace Domain\Order\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'method',
        'payload',
    ];

    protected $casts = [
        'payload' => 'collection',
    ];
}
