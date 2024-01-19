<?php

namespace App\Http\Controllers;

use Exception;
use App\Mail\ExampleMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendEmail(Request $request)
    {
        $validate = [
            'name' => 'required|string',
            'email' => 'required|email:dns',
            'message' => 'required|string',
        ];

        $request->validate($validate);

        $email = $request->input('email');
        $name = $request->input('name');

        $recipient = 'contact@alcancesolutions.com';
        $content = $request->input('message');
        $subject = $name;

        try {
            Mail::raw($content, function ($message) use ($email, $name, $recipient, $subject) {
                $message->from($email, $name)
                    ->to($recipient)
                    ->replyTo($email)
                    ->subject($subject);
            });

            // Mail::send([], [], function ($message) {
            //     $message->from('anggitagalih@gmail.com', 'Anggita');
            //     $message->to('wgalih1234@gmail.com');
            //     $message->subject('Subjek Email');
            //     $message->setBody('Isi email', 'text/html');
            // });

            return response()->json([
                'status' => true,
                'message' => 'Email sent successfully',
            ]);

        } catch (Exception $e) {
            echo $e->getMessage();
            return response('Terjadi kesalahan pada server', 500);
        }
    }
}
