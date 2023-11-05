<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'intitule',
        'description',
        'tarifs',
        'horaires',
    ];
    

    public function DemandeService(){
        return $this->belongsToMany(Client::class, 'demande_services', 'client_id', 'service_id')
        ->withPivot('date_debut', 'date_fin', 'adresse', 'status');
    }

    public function Paiement(){
        return $this->belongsToMany(Client::class, 'paiements', 'client_id', 'service_id')
        ->withPivot('montant');
    }
}
