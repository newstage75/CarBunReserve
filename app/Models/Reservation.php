<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    //Scope
    public function scopeWhereHasReservation($query, $start, $end){
        $query->where(function($q) use($start, $end){ //解説1
            $q->where('start_at', '>=',$start)
              ->where('start_at', '<', $end);
        })
        ->orWhere(function($q) use($start, $end){ //解説2
            $q->where('end_at', '>',$start)
              ->where('end_at', '<=', $end);
        })
        ->orWhere(function($q) use($start, $end){ //解説3
            $q->where('start_at', '<',$start)
              ->where('end_at', '>', $end);
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo('App\Models\Car');
    }


}