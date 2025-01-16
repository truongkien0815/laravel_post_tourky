<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;



// use Illuminate\https\Request;
// use Illuminate\Support\facades\Session;
// use DB;


class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    public $view;
    public $dataView;
    public $config;
    public $fileAttach;

    /**
     * Create a new message instance.
     *
     * @return void
     */
  
   public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
   


public function build()
{

    return $this->subject('HÓA ĐƠN MUA HÀNG')->view('emails.send_mails',['data'=>$this->data]);

}
}
