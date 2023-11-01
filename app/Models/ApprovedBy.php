<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprovedBy extends Model
{
    use HasFactory;
    protected $fillable = [
        'approval_note_id',
        'approved_by_id',
        'approval_status',
        'created_at',
        'updated_at',
    ];
}
