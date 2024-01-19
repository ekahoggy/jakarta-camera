<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Kegiatan extends Model
{
    // public $timestamps = false;
    use HasFactory, Notifiable;
    protected $table = 'm_events';

    protected $fillable = [
        "event",
        "event_en",
        "city",
        "place",
        "date",
        "zona",
        "photo",
        "intro",
        "intro_en",
        "is_status",
        "created_at",
        "updated_at",
    ];

    // get donasi yang berhasil
    function donationPaid() {
        return $this->hasMany(Donations::class, 'm_events_id')->where('transaction_status', 'Paid');
    }

    // get donasi yang gagal
    function donationUnpaid() {
        return $this->hasMany(Donations::class, 'm_events_id')->where('transaction_status', 'Unpaid');
    }

    // get semua donasi
    function allDonation() {
        return $this->hasMany(Donations::class, 'm_events_id');
    }

    // get type donasi
    function getType() {
        return $this->hasMany(Donations::class, 'm_events_id')->select('m_events_id', 'type')->groupBy('type');
    }

    // get total donasi yang berhasil
    function getTotalDonation(){
        return $this->hasMany(Donations::class, 'm_events_id')->where('transaction_status', 'Paid');//->sum('total_donation');
    }
}
