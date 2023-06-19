<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendList extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'user_id',
        'invitation_type',
    ];

    protected $visible = [
        'name',
        'email',
        'user_id',
        'invitation_type',
    ];

    protected $editable = [
        'name',
        'email',
        'user_id',
        'invitation_type',
    ];
}
