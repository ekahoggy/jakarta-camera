<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogUser extends Model
{
    use HasFactory;

    protected $table = 'l_users';

    protected $fillable = [
        'ref_name',
        'ref_id',
        'notes',
        'created_at',
        'created_by',
        'updated_at'
    ];
}
