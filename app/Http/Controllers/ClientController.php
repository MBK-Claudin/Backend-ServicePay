<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConnexionRequest;
use App\Http\Requests\DemandeRequest;
use App\Http\Requests\inscription;
use App\Http\Requests\inscriptionRequest;
use App\Http\Requests\ModifierMDP;
use App\Http\Requests\ModifierNOM;
use App\Http\Requests\SuggestionRequest;
use App\Models\Client;
use App\Models\DemandeService;
use App\Models\Suggestion;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    
    /**
     * validation des information d'inscription
     */
    public function Validerinfo(inscriptionRequest $request){
        $request->validated();

        $infoclient = [
                'nom' => $request->nom_client,
                'email' => $request->email,
                'mot_de_passe' => $request->mot_de_passe,
                'code_otp' => $request->code_otp,
            
        ];

        return response([
            "infoclient" => $infoclient,
        ]);
    }


    /**
     * inscription des clients
     */
    public function inscription(inscription $request){
        $request->validated();

        $infoclient = [
            'nom_client' => $request->nom_client,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
        ];

        $client = Client::create($infoclient);
     
        return response([
            'client' => $client,
        ]);
    }

    

    /**
     * connexion du client
     */
    public function Connexion(ConnexionRequest $request){

        $request->validated();

        $client = Client::where('email', $request->email)->first();
        //$admin = Admin::where('phone', $request->phone)->first();
        
        if($client && hash::check($request->mot_de_passe, $client->mot_de_passe)){
            $token = $client->createToken('servicespay')->plainTextToken;
            return response([
                'client' => $client,
                'token' => $token,
            ], 201);
        }
    }


    /**
     * envoi des demandes de serives
     */
    public function DemandeService(DemandeRequest $request, $idclient, $idservice){
        $request->validated();

        $info = [
            'client_id' => $idclient,
            'service_id' => $idservice,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'adresse' => $request->adresse,
        ];

        DemandeService::create($info);
    }

    /**
     * publier la suggestion du client
     */
    public function EnvoiSuggestion(SuggestionRequest $request, $id){
        $request->validated();

        $message = [
            'contenu' => $request->contenu,
            'client_id' => $id,
        ];

        $suggestion = Suggestion::create($message);

        return response([
            'message' => $suggestion,
        ]);
    }

    /**
     * envoi des information du client
     * 
     */
    public function EnvoiClient($id){
        $client = Client::find($id);

        return response([
            'client' => $client,
        ]);
    }


    /*
        modifidier le nom du client 
    */
    public function modifierNom( $id, ModifierNOM $request){
        $request->validated();
        $client = Client::find($id);

        if($client){
                $client->nom_client = $request->nom;
                $client->save();
        }
        return response([
            'client' => $client,
        ]);
    }


    /*
        Modifier le mot de pasee du client
    */
    public function modifierMDP( $id, ModifierMDP $request){
        $request->validated();
        $client = Client::find($id);

        if($client){
            $client->mot_de_passe = $request->mot_de_passe;
        }
    }

   /*
        Demande de services envoyer par le client
    */
    public function DemandeEnvoyer($id){
        $demandes = Client::find($id);

        dd($demandes);

        
    }

    /**
     * demandes des services traiter par l'administration (les notification)
     */
    public function Notification($id){
        $notif = DemandeService::join('clients', 'demande_services.client_id', '=', 'client.id')
        ->join('services', 'demande_services.service_id', '=', 'services.id')
        ->select('services.intitule', 'demande_services.date_debut', 'demande_services.date_fin', 'demande_services.created-at')
        ->where('clients.id', $id);

        return response([
            'demandes' => $notif,
        ]);
    }
}
