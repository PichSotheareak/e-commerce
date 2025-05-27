<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Staff extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'staff';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'name',
        'gender',
        'phone',
        'profile',
        'current_address',
        'position',
        'salary',
        'branch_id',
    ];

    protected $dates = ['deleted_at'];

    public function branch(){
        return $this->belongsTo(Branch::class , 'branch_id');
    }
}

