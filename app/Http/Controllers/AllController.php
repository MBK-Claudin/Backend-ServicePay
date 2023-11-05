<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class AllController extends Controller
{
    //
    public function AllService(){
        $services = Service::select('id', 'intitule', 'description', 'tarifs', 'horaires')->get();
        return response([
            'service' => $services,
            'messase' => 'ca doit passer! ca passe toujours !',
        ]);
    }
}
