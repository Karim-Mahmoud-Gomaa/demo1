<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Campaign extends Model
{
    protected $table = 'campaigns';
    protected $guarded = [];
    protected $casts = [
        'from' => 'datetime',
        'to' => 'datetime',

        'total' => 'float',
        'images' => 'array',
        
        'daily_budget' => 'float',
    ]; 
   
    // //////////////////////////////////////////////Relations
    public function created_by()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
