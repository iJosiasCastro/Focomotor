<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Mail\ContactMailable;
use App\Mail\MessageMailable;
use App\Mail\PaymentLinkMailable;
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
        Mail::to($vehicle->user['email'])->send($email);
        Mail::to(env('ADMIN_MAIL'))->send($email);
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
        Mail::to(env('ADMIN_MAIL'))->send($email);
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

        $planToLink = [
            'x10 Publicaciones' => 'https://www.mercadopago.com.ar/subscriptions/checkout?preapproval_plan_id=2c938084930506df019307fbfed100fd',
            'x50 Publicaciones' => 'https://www.mercadopago.com.ar/subscriptions/checkout?preapproval_plan_id=2c93808492eb461b019307fc901c0b15 ',
            'x120 Publicaciones' => 'https://www.mercadopago.com.ar/subscriptions/checkout?preapproval_plan_id=2c93808492eb461b019307fc55a70b14'
        ];
        
        if (isset($planToLink[$request['plan']])) {
            $request['payment_link'] = $planToLink[$request['plan']];
        }

        // Email to concessionaire
        $email = new PaymentLinkMailable($request->all());
        Mail::to($request['email'])->send($email);

        // Email to admin
        $email = new PlanMailable($request->all());
        Mail::to(env('ADMIN_MAIL'))->send($email);
        return 'Successful';
    }
}

