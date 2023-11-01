<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecommendedBy extends Model
{
    use HasFactory;
    protected $fillable = [
        'approval_note_id',
        'recommended_by_id',
        'approval_status',
        'created_at',
        'updated_at',
    ];
}
