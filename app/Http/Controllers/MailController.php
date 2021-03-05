<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    //
    public function mail($id){

        $data = request('name');

        $to_email = "louis.gailleton@gmail.com";
        //$data = array("nomEleve" => "$prenomEleve $nomEleve", "nomTuteur" => "$prenomTuteur $nomTuteur");
        Mail::send('mail', $data, function($message) use ($to_email) {
            $message->to($to_email)
                ->subject('Lara mail sujet');
        });
    }
}
