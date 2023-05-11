<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCampaign extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'emails',
        'status',
        'progress',
        'time_gap',
        'launch_at',
        'template_id',
    ];
    protected $casts = [
        'emails'=>'array',
        'launch_at'=> 'datetime',
    ];
    public function template(){
        return $this->belongsTo(EmailTemplate::class);
    }
    public function pushStatus($status){
        $this->status = $status;
        $this->save();
    }
}
