<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;

class ContactUsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * NOTE : Its a Ajax Call
     * NOTE : This method is used to add attributes for a table
     * 
     * Step 1 : It deletes all attributes for that table.
     * Step 2 : Insert all attributes for that table.
     *
     * @param  $request
     * 
     * @return generate view page
     */
    public function index(Request $request)
    {
        # Clear Config
        exec('php artisan config:cache');
        
        # Prepare data
        $data = array('name'=>$request->input('name'),'email'=>$request->input('email'),'mobileno'=>$request->input('mobileno'),'message'=>$request->input('message'));

        # name
        $name = $request->input('name');
        
        # Send Mail
        Mail::send(['text'=>'contactus'], $data, function($message) use($name) {
            $message->to('en.pavankumar@gmail.com', 'AGC - Autogencode');
            $message->subject($name.' Contacted To AGC');
            $message->from('en.pavankumar@gmail.com');
        });
                
        return view('welcome');
    }
    
}
