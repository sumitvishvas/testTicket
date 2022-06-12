<?php

namespace App\Http\Controllers;
use App\Models\Ticket; 

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index(Request $req)
    {
        
    $validator = \Validator::make($req->all(),			
    array(
        
        'description' => 'required',
        'date' => 'required',
        'status' => 'required',
       
       
    )
);


if($validator->fails())
{
    $response['flag'] = false;
    $response['errors'] = $validator->getMessageBag();


}else{ 
    $ticket = Ticket::orderBy('id','desc')->first();
    // dd($ticket);
    $n=1;
    if(is_null($ticket)){

        $ticket_no='TKT'.$n;
    }else{
        $ticket_no='TKT'.$ticket->id+$n;

    }
    // $ticket_no='TKT'.$n;
      
    $tickets= new Ticket();
    $tickets->ticket_no=$ticket_no;
    $tickets->date=$req->date;
    $tickets->description=$req->description;
    $tickets->status=$req->status;

    if($tickets->save()){
        $response['status']=true;
        $response['msg']='Ticket created successfully.';

    }else{
        $response['status']=false;
        $response['msg']='TSomething went wrong';
    }



}
return redirect()->back()->with('success', 'Ticket is created');
    }


    public function showTicket()
    {

        $data=[];
        $data['tickets']=Ticket::get();
        return view('welcome', $data);
        # code...
    }
}
