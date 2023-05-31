<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

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
        'was_sent_to'
    ];
    protected $casts = [
        'emails'=>'array',
        'was_sent_to'=>'array',
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
    public function pushToSent($email){
        try{

            $was_sent_to = $this->was_sent_to ?? [];
            $was_sent_to[] = $email;
            $this->was_sent_to = $was_sent_to;
            $this->save();
        } catch(Exception $ex){
            Log::channel('campaign_errors')->error($ex->getMessage() . '- with campaign :' . $this->id);

        }
    }
    public function update_hitory_log($message, $email = '')
    {
            $new_entry =
            [
                'message' => $message,
                'updated_at' => now(),
                'email'=> $email,
            ];
            $log = $this->history_log ?? [];
            $new_log = array_merge([$new_entry], $log);
            $this->history_log = $new_log;
            $this->save();
        return;
    }
}
