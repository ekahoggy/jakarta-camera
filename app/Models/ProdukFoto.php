<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;

class ProdukFoto extends Model
{
    use HasFactory;

    protected $table = 'm_produk_foto';

    protected $fillable = [
        'm_produk_id',
        'foto',
        'is_main',
        'urutan'
    ];

    protected $casts = [
        'id' => 'string'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            try {
                $model->id = Generator::uuid4()->toString();
            } catch (UnsatisfiedDependencyException $e) {
                abort(500, $e->getMessage());
            }
        });
    }
}
