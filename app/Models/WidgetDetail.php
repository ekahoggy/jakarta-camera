<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WidgetDetail extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'm_widgets_detail';

    protected $fillable = [
        'widgets_id',
        'nominal'
    ];
}
