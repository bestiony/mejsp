<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
    ];
    
    public function subscribers(){
        return $this->hasMany(Subscribers::class);
    }
    public function detachSubscribers(){
        $subscribers = $this->subscribers;
        Subscribers::whereIn('id',$subscribers->pluck('id')->toArray())->update(['email_list_id' => null]);
    }
}
