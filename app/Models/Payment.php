<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    // ✅ Define table name explicitly if it doesn't follow Laravel's plural naming convention
    protected $table = 'payment'; // Recommended to use plural for table name

    // ✅ Define fillable fields
    protected $fillable = [
        'invoice_id',
        'payment_date',
        'amount',
        'payment_method_id',
        'branch_id',
    ];

    // ✅ Define dates (optional if using SoftDeletes in Laravel 8+)
    protected $dates = ['deleted_at'];

    // ✅ Relationships

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function paymentMethod(){
        return $this->belongsTo(PaymentMethod::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
