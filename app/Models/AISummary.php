<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AISummary extends Model
{
    use HasFactory;
    protected $fillable = [
        'business_id',
        'ai_summary',
        'created_at',
        'updated_at',
    ];

    public $table = 'ai_summaries';

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
