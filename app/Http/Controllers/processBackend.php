<?php

namespace App\Http\Controllers;

use App\Mail\mailToSend;
use App\mailCl;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class processBackend extends Controller
{
    function sendMail(Request $request){
        $mailList = MailCl::all();
        $mail = $mailList[0];
        // $payload = array('file' => $request->file, 'name' =>'Pan Muangsaen');
        foreach($mailList as $mail){
            $payload = array('file' => $request->file, 'name' => $mail->name);
            Mail::to($mail->email)->send(new mailToSend($payload));
        }
        
        // Mail::to('naruka1023@yahoo.com')->send(new mailToSend($payload));
        return array('success' => count($mailList));
    }
}
