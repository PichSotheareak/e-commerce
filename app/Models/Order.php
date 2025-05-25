<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'order';
    protected $fillable = ['customer_id', 'user_id', 'total_amount', 'remark', 'payment_status','status','branch_id','order_date'];
}
