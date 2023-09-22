<?php

namespace App\Http\Controllers;

use App\Mail\MailSender;
use Illuminate\Support\Facades\Mail as FacadesMail;

class TestEmailController extends Controller
{
    public function sendEmail()
    {
        $data['email'] = 'ziaulhaque953@gmail.com';
        $data['title'] = 'Test';
        $data['subject'] = 'Test sub';
       FacadesMail::to('ziaulhaque953@gmail.com')->send(new MailSender($data));
    }
}
