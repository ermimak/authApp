<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function generateCode()
    {
        $code = rand(100000, 999999);

        UserCode::updateOrCreate([
            'user_id' => auth()->user()->id,
            'code' => $code
        ]);

        $receiverNumber = auth()->user()->phone;
        $message = "Your 6 Digit OTP Number is ". $code;

        try {
            $account_sid = env("TWILIO_SID");
            $auth_token = env("TWILIO_TOKEN");
            $from_number = env("TWILIO_FROM");

            //$client = new UserCode($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $from_number,
                'body' => $message]);

        } catch (\Exception $e) {
           info("Error...");
        }
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
