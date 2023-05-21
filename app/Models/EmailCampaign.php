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
        'history_log',
    ];
    protected $casts = [
        'emails'=>'array',
        'history_log'=>'array',
        'launch_at'=> 'datetime',
    ];
    public function template(){
        return $this->belongsTo(EmailTemplate::class);
    }
    public function pushStatus($status){
        $this->status = $status;
        $this->save();
    }
    public function update_hitory_log($message)
    {
        $log = $this->history_log;
        $log[] = [
            'message' => $message,
            'updated_at' => now(),
        ];
        $this->history_log = $log;
        $this->save();
    }
}
