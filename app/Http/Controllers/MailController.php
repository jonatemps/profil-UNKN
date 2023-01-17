<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function basic_email() {
        $data = array('name'=>"Virat Gandhi");

        Mail::send(['text'=>'mail'], $data, function($message) {
           $message->to('mupene7@gmail.com', 'Tutorials Point')->subject
              ('Confirmation de l’Admission');
           $message->from('jonathan.mupene@educ.cd','Unikin Admission');
        });
        echo "Basic Email Sent. Check your inbox.";
     }


    public function html_email() {
        // $data = array('name'=>"Virat Gandhi");
        // dd(Auth::user());
        $data = [
                'name' => Auth::user()->name,
                'pourcentage' => Auth::user()->etude->pourcentage,
                'faculty' => Auth::user()->choice->faculty->libellefac,
                'department' => Auth::user()->choice->department->libelledpt
                ];
// dd($user);
        Mail::send('mailCongrat', $data, function($message) {
           $message->to('mupene7@gmail.com', 'Tutorials Point')->subject
              ('Confirmation de l’Admission');
           $message->from('jonathan.mupene@educ.cd','Unikin Admission');
        });
        echo "HTML Email Sent. Check your inbox.";
     }
}
