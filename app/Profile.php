<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Profile
 * @package App
 *
 * @property integer id
 * @property string display_name
 * @property string uid
 * @property string picture
 * @property \DateTime created_at
 * @property \DateTime updated_at
 */
class Profile extends Model
{
    protected $fillable = [
        'display_name', 'uid', 'picture'
    ];
}
