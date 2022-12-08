<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name', 'code', 'group', 'flag'
    ];

    public function games()
    {
        return $this->hasMany(Game::class);
    }
}
