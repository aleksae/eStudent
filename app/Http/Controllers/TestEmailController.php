<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SendGrid\Mail\Mail as SendGridMail;
use SendGrid;

class TestEmailController extends Controller
{
    public function sendTestEmail()
    {
        $email = new SendGridMail();
        $email->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        $email->setSubject("Da li ovo sanje radi?");
        $email->addTo("lukamuticxy@gmail.com", "eStudent");
        $email->addContent("text/plain", "Da li ovo sranje radi?");
        $email->addContent("text/html", "<strong>and easy to do anywhere, even with PHP</strong> <em>jeste kurac</em>");

        $sendgrid = new SendGrid(env('SENDGRID_API_KEY'));

        try {
            $response = $sendgrid->send($email);
            echo $response->statusCode() . "\n";
            print_r($response->headers());
            echo $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }
    }
}
