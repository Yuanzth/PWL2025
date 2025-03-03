<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    use HasFactory;

    protected $table = 'm_user';        // Mendefinisikan nama tabel yang digunakan untuk model ini
    protected $primaryKey = 'user_id';  // Mendefinisikan nama primary key yang digunakan
    protected $fillable = ['user_id', 'level_id', 'username', 'nama', 'password'];
}
