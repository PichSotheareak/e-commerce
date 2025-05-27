<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'invoice_item';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'qty',
        'price',
        'sub_total',
    ];

    protected $dates = ['deleted_at'];

    // Optional: define relationships

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}

