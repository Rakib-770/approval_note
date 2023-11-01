<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillApproval extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'approval_note_id',
        'bill_approval_description',
        'bill_approval_narration',
        'file', // Ensure 'file' is listed here
    ];
}
