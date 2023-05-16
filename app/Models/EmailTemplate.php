<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'subject',
        'template',
        'status',
    ];
    public function campaigns(){
        $this->hasMany(EmailCampaign::class, 'template_id');
    }
}
