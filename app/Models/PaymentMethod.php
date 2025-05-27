<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentMethod extends Model
{
    use SoftDeletes;

    protected $table = 'payment_method'; // keep as plural for Laravel convention

    protected $fillable = [
        'name',
        'account_number',
        'qrcode',
    ];

    protected $dates = ['deleted_at'];

    public function payment()
    {
        return $this->hasMany(Payment::class);
    }
}



