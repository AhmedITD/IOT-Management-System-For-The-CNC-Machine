<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class gcode extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'name',
        'email',
        'password',
        'photo',
        'gcode',
        'finger_print',
        'permit',
        'settings_value',
        'realTimeInfo'
    ];
}
