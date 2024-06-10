<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'source',
        'created_by',
        'owner'
    ];

    public function createdBy(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function owner(){
        return $this->belongsTo(User::class, 'owner');
    }


}
