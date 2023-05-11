<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    // use HasFactory;

    public $table   = 'subscribers';
    public $guarded = [];

    public function email_list(){
        return $this->belongsTo(EmailList::class);
    }

}
