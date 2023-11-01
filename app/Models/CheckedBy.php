<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckedBy extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_note_id', // Add 'approval_note_id' to the fillable array
        'checked_by_id',
        'approval_status',
        'created_at',
        'updated_at',
    ];
}
