<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\RevisorMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;

class ContactController extends Controller
{  
   public function workMail(){

      $user = Auth::user();

      // Verifica se l'utente ha già fatto la richiesta
      if ($user->contact_requested) {

         return redirect('/work-with-us')->with('error', 'Hai già effettuato la richiesta.');

      } else {

         // Invia la mail
         $mail = new RevisorMail($user);
         Mail::to('admin@presto.it')->send($mail);

         // Imposta il flag sulla richiesta nel modello dell'utente
         $user->update(['contact_requested' => true]);
         
         return redirect('/work-with-us')->with('success', 'Thank you! Your application has been successfully submitted.');
      }

      
    
   }


   public function makeRevisor (User $user){
      
      Artisan::call('presto:make-user-revisor', ["email"=>$user->email]);
      return redirect('/')->with('success', 'Complimenti! L\' utente è diventato revisore');
      
   }
}