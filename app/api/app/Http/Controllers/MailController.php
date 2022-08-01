<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Mail\ContactMailable;
use App\Mail\MessageMailable;
use App\Mail\PlanMailable;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function message(MessageRequest $request, Vehicle $vehicle){
        $request->validate([
            "name" => "required|min:4|max:40",
            "contact" => "required|min:8|max:40",
            "message" => "required|min:10|max:400",
        ]);

        $email = new MessageMailable($request->all(), $vehicle);
        // return $vehicle->user['email'];
        Mail::to($vehicle->user['email'])->send($email);
        // Mail::to($vehicle->user['email'])->send($email);
        return 'Successful';
    }

    public function contact(Request $request){
        $request->validate([
            "name" => "required|min:4|max:40",
            "contact" => "required|min:8|max:40",
            "city" => "required|min:8|max:60",
            "message" => "required|min:10|max:400",
        ]);

        $email = new ContactMailable($request->all());
        Mail::to('josiascastro2003@gmail.com')->send($email);
        return 'Successful';
    }

    public function plan(Request $request){
        $request->validate([
            "concessionaire_name" => "required|min:4|max:40",
            "name" => "required|min:4|max:40",
            "email" => "required|min:4|max:40",
            "phone" => "required|min:4|max:40",
            "city" => "required|min:4|max:60",
            "plan" => "required|min:4|max:60",
        ]);

        $email = new PlanMailable($request->all());
        Mail::to('marcelocastroarg@gmail.com')->send($email);
        return 'Successful';
    }
}

