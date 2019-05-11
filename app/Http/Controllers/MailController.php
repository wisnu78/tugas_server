<?php

namespace App\Http\Controllers;

use App\Mail;
use Illuminate\Http\Request;
use App\Item;

class MailController extends Controller
{
    public function check($id){
        $mail = Mail::where("code",$id)->with('items')->first();
        if($mail != null){
            return response()->json(['status' => 'success','data'=>$mail],200);
        }else{
            return response()->json(['status' => 'error'],200);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $mail = new Mail;

        $mail->name     = $request->name;
        $mail->date     = $request->date;
        $mail->type     = $request->type;
        $mail->code     = $request->code;
        $mail->phone    = $request->phone;
        $mail->client   = $request->client;
        $mail->save();
        $newItems = [];
        foreach ($request->items as $key => $val) {
            $newItems[] = array(
                'mail_id'   => $mail->id,
                'name'      => $val['name'],
                'qty'       => $val['qty'],
                'price'     => $val['price'],
                'total'     => $val['total']
            );
        }
        Item::insert($newItems);
        return response()->json(['status'=>'success'],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function show(Mail $mail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(Mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mail $mail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id,Request $request)
    {
        $mail = Mail::where("code",$id)->first();
        $items = Item::where("mail_id",$mail->id)->get();
        foreach ($items as $item) {
            $item->delete();
        }
        $mail->delete();
        $mail = Mail::where("code",$id)->with("items")->first();
        return response()->json(['status'=>'success','data'=>$mail],200);
    }
}
