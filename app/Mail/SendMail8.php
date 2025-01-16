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
    // public function __construct($view, $dataView = array(), $config = array(), $attach = array())
    // {
    //     $this->view = $view;
    //     $this->dataView = $dataView;
    //     $this->config = $config;
    //     $this->fileAttach = $attach['fileAttach'] ?? [];
    // }
   public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    // public function build()
    // {
    //     $this->to($this->config['to']);
    //     if (!empty($this->config['cc'])) {
    //         $this->cc($this->config['cc']);
    //     }
    //     if (!empty($this->config['bbc'])) {
    //         $this->bbc($this->config['bbc']);
    //     }
    //     if (!empty($this->config['replyTo'])) {
    //         $this->replyTo($this->config['replyTo']);
    //     }

    //     if (!empty($this->config['subject'])) {
    //         $this->subject($this->config['subject']);
    //     }

    //     if (!empty($this->fileAttach)) {
    //         //->attach('/path/to/file');

    //         // ->attach('/path/to/file', [
    //         //     'as' => 'name.pdf',
    //         //     'mime' => 'application/pdf',
    //         // ]);

    //         foreach ($this->fileAttach as  $attachment) {
    //             if(!empty($attachment['file_path'])) {
    //                 if(!empty($attachment['file_name'])) {
    //                     $this->attach($attachment['file_path'], [
    //                         'as' => $attachment['file_name']
    //                     ]);
    //                 } else {
    //                     $this->attach($attachment['file_path']);
    //                 }
    //             }
    //         }

    //     }

    //     $this->from( setting_option('smtp-username'), setting_option('company_name'));

    //     return $this->view($this->view)->with($this->dataView);
    // }
//     public function send_mail(Request $request)
//     {
//   $data= $request->all();
//   $emails = $data['emails']??'';

//   \mail::to($emails)->send(new \App\mail\SendMail(['emails'=> $emails]));
//   Session::flast('flash_message','thành công');
//   return views('hehe');
//     }


public function build()
{

    return $this->subject('HÓA ĐƠN MUA HÀNG')->view('emails.send_mails',['data'=>$this->data]);
//    return $this->subject($this->subject)->replyTo('truongkien0815@gmail.com','kien')->view('theme.page.tuyen-dung',
//    ['data'=>$this->data]);
}
}
