<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contestant extends Model
{
    use HasFactory;
    protected $table = "contestants";
    protected $fillable = [
        "name",
        "advocacy",
        "photo",
        "contestantNum",
        "eventID",
        "address",
        "age",
        "chest",
        "waist",
        "height",
        "weight",
        "hips"
    ];
    public function preliminary()
    {
        return $this->hasOne(Preliminary::class, 'contestantID', 'id');
    }
    public function swimwear()
    {
        return $this->hasOne(Swimwear::class, 'contestantID', 'id');
    }
    public function gown()
    {
        return $this->hasOne(Gown::class, 'contestantID', 'id');
    }
}
