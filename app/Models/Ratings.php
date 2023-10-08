<?php

use App\Models\User;
use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $table = 'ratings';
    protected $fillable = [
        'rate',
        'service',
        'given',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function given()
    {
        return $this->belongsTo(User::class, 'given');
    }
}
