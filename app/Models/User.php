<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CustomerImage;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;



class User extends Authenticatable
{
    use Notifiable, HasFactory;

    // Specify the table associated with the model
    protected $table = 'user';

    // Specify the primary key of the table
    protected $primaryKey = 'user_id';

    // Define the fillable attributes
    protected $fillable = [
        'email',
        'username',
        'password',
        'type',
        'email_verified',
        'verification_token',
    ];

    // Hide these attributes when serializing the model
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Cast attributes to appropriate types
    protected $casts = [
        'type' => 'string',
        'email_verified' => 'boolean',
        'created_at' => 'datetime',
        'modified_at' => 'datetime',
        'last_login' => 'datetime',
    ];

    // Disable automatic timestamps for the model
    public $timestamps = false;

    /**
     * Generate a random and unique username.
     *
     * @return string
     */
    public static function generateRandomUsername()
    {
        do {
            $username = 'user' . rand(10000, 99999);
        } while (self::where('username', $username)->exists());

        return $username;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $resetUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $this->getEmailForPasswordReset(),
        ], false));

        Mail::send('emails.password-reset', ['resetUrl' => $resetUrl], function ($message) {
            $message->to($this->email);
            $message->subject('Reset Your Password');
        });
    }

    /**
     * Define the relationship with the CustomerImage model.
     */
    public function customerImage()
    {
        return $this->hasOne(CustomerImage::class, 'customer_id', 'customer_id');
    }
        // In app/Models/User.php
    public function customer()
    {
        return $this->hasOne(Customer::class, 'user_id', 'user_id');
    }
    public function addresses()
    {
        return $this->hasMany(CustomerAddress::class, 'customer_id', 'customer_id');
    }
    public function isMerchant()
    {
        return $this->type === 'merchant'; // Assuming 'type' column defines user role
    }
    public function isCustomer()
    {
        return $this->type === 'customer'; // Assuming 'type' column defines user role
    }
    public function shop()
    {
        return $this->hasOne(Shop::class, 'merchant_id', 'user_id');
    }
    public function merchant()
    {
        return $this->hasOne(Merchant::class, 'user_id');
    }
    public function isAdmin()
    {
        return $this->type === 'admin'; // Assuming 'type' column defines user role
    }



}
