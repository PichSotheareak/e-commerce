<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'invoice';
    protected $fillable = ['user_id', 'customer_id', 'transaction_date',
        'pick_up_date_time','total_amount','paid_amount','status', 'order_id','payment_method_id'
    ];
    public function order() {
        return $this->belongsTo(Order::class , 'order_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class , 'customer_id');
    }

    public function user() {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function paymentMethod() {
        return $this->belongsTo(PaymentMethod::class , 'payment_method_id');
    }


}
