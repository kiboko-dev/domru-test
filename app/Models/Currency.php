<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 * @package App\Models
 *
 * @property string code
 * @property int ratio
 * @property float amount
 */
class Currency extends Model
{
    public $timestamps = true;
    protected $fillable = ['code','amount'];
    protected $table = 'rates';
    protected $hidden = ['created_at','updated_at','id'];
}
