<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Auth;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;


class Bunch extends Model
{
    use Selectable, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'created_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($table) {
            $table->created_id = Auth::user()->id;
        });
    }
    public function scopeOwned($query){
        return $query->where('created_id', Auth::user()->id);
    }

}
