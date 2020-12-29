<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForgotPasswordToken extends Model
{
    protected $fillable = ['user_id', 'token', 'created_at'];
    protected $table = 'public.forgot_password_tokens';
    protected $primaryKey = 'token';
    protected $dates = ['created_at'];
    public $incrementing = false;
    public $timestamps = false;
    public function user(){
        return $this->belongsTo(User::class);
    }
}
