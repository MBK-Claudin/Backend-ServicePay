<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Client extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom_client',
        'email',
        'mot_de_passe',
        'code_otp',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mot_de_passe',
        'code_otp',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'mot_de_passe' => 'hashed',
    ];

    public function Suggestion() : HasMany {
        return $this->hasMany(Suggestion::class);
    }

    public function DemandeService(){
        return $this->belongsToMany(Service::class, 'demande_services', 'client_id', 'service_id')
        ->withPivot('date_debut', 'date_fin', 'adresse', 'status');
    }

    public function Paiement(){
        return $this->belongsToMany(Service::class, 'paiements', 'client_id', 'service_id')
        ->withPivot('montant');
    }
}