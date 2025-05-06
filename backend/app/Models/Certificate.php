<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id', 'document_type', 'purpose', 'status', 'reason', 'is_claimed', 'claimed_at'
    ];
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
