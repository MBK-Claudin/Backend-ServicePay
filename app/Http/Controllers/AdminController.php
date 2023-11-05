<?php

namespace App\Http\Controllers;

use App\Http\Requests\AjouterServiceRequest;
use App\Http\Requests\ConnexionRequest;
use App\Http\Requests\inscriptionAdminRequest;
use App\Http\Requests\ModifeirMDP;
use App\Http\Requests\ModifeirNom;
use App\Http\Requests\ModifierMDP;
use App\Http\Requests\ModifierNOM;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\DemandeService;

class AdminController extends Controller
{
    public function InscriptionAdmin(inscriptionAdminRequest $request){
        $request->validated();

        $adminInfo = [
            'nom_admin' => $request->nom_admin,
            'email' => $request->email,
            'mot_de_passe' => Hash::make($request->mot_de_passe),
        ];

        $admin = Admin::create($adminInfo);
        $token = $admin->createToken('servicespay')->plainTextToken;
     
        return response([
            'client' => $admin,
            'token' => $token,
        ]);

        
    }

    public function ConnexionAdmin(ConnexionRequest $request){

        $request->validated();

        $admin = Admin::where('email', $request->email)->first();
        
        if($admin && hash::check($request->mot_de_passe, $admin->mot_de_passe)){
            $token = $admin->createToken('servicespay')->plainTextToken;
            return response([
                'client' => $admin,
                'token' => $token,
            ], 201);
        }
    }

    public function AjouterServices(AjouterServiceRequest $request){
        $request->validated();
        
        $service = [
            'intitule' => $request->intitule,
            'description' => $request->description,
            'tarifs' => $request->tarifs,
            'horaires' => $request->horaires,
        ];

        Service::create($service);
    }

    public function modifierNom( $id, ModifierNOM $request){
        $request->validated();
        $client = Admin::find($id);

        if($client){
                $client->nom_client = $request->nom;
                $client->save();
        }
    }

    public function modifierMDP( $id, ModifierMDP $request){
        $request->validated();
        $client = Admin::find($id);

        if($client){
            $client->mot_de_passe = $request->mot_de_passe;
            $client->save();
        }   
    }

    public function SuprimerService( $id){
        $service = Service::find($id);

        if($service){
            $service->delete();
            //$service->save();
        }
    }

    public function ModifierService( $id, AjouterServiceRequest $request){
        $request->validated();
        $service = Service::find($id);

        if($service){
            $service->intitule = $request->intitule;
            $service->description = $request->description;
            $service->tarifs = $request->tarifs;
            $service->horaires = $request->horaires;

            $service->save();
        }
    }

    /**
     * demandes de services des clients non traiter
     */
    public function DemandeServices() {
        $demandes = DemandeService::join('clients', 'demande_services.client_id', '=', 'client.id')
        ->join('services', 'demande_services.service_id', '=', 'services.id')
        ->select('services.intitule', 'demande_services.date_debut', 'demande_services.date_fin', 'demande_services.created-at');

        return response([
            'demandes' => $demandes,
        ]);
    }

 
}
