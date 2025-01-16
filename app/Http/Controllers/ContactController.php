<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Model\ShopEmailTemplate;
use App\Mail\SendMail;

class ContactController extends Controller
{
    use \App\Traits\LocalizeController;
    
    public $data = [
        'error' => false,
        'success' => false,
        'message' => ''
    ];

    public function index(){
        $this->localized();
        $this->setData();
        return view($this->templatePath .'.page.contact', ['data' => $this->data]);
    }

    public function getContact(Request $request,$type)
    {
        if($type == 'request-contact')
        {
            $this->data['status'] = 'success';
            $this->data['type'] = $type;
            $this->data['url_current'] = $request->url_current;
            $this->data['product_title'] = $request->product_title;
            $this->data['view'] = view('theme.page.includes.get-contact-form', ['data' => $this->data ])->render();
        }

        return response()->json($this->data);
    }
    
    public function submit(Request $rq) {
        $detail = $rq->input('contact', false);
        if($detail){
            $email = new \App\Mail\contactMail($detail);
            $sendto =  setting_option('email');
            try {
                Mail::to($sendto)->send($email);
            } catch (\Exception $e) {
                $this->setData();
                $this->data['message'] = 'sendMailError';
                $this->data['error'] = true;
                return $this->index();
            }
            // return redirect()->back()->with(['success' => true, 'message' => 'Gửi mail thành công']);
            return redirect(url('contact'))->with(['success' => true, 'message' => 'Gửi mail thành công']);
            // return $this->index();
        }
    }

    private function setData () {
        $this->data['page'] = \App\Page::where('slug', 'contact')->first();
        $this->data['seo'] = [
            'seo_title' => $this->data['page']->seo_title!=''? $this->data['page']->seo_title : $this->data['page']->title,
            'seo_image' => $this->data['page']->image,
            'seo_description'   => $this->data['page']->seo_description ?? '',
            'seo_keyword'   => $this->data['page']->seo_keyword ?? '',

        ];
    }


    public function recruitmentPost(Request $request)
    {
        $data = request()->all();
       


        $subject = 'Gửi thông tin liên hệ';
       
        \App\Contact::create([
            'fullname'  => $request->fullname,
            'mobile'  => $request->mobile,
            'address'  => $request->address,
            'content'  => $request->content,
            'question_id'=> $request->question,
            'status'  => 0,
        ]);

        $emailContentAdmin = ShopEmailTemplate::where('group', 'contact_to_admin')->first();
        $emailContent = ShopEmailTemplate::where('group', 'contact_to_user')->first();

        $contentAdmin = $emailContentAdmin->text;
        $content = $emailContent->text;

        $dataFind = [
            '/\{\{\$userName\}\}/',
            '/\{\{\$userPhone\}\}/',
            '/\{\{\$userEmail\}\}/',
            '/\{\{\$question\}\}/',
            '/\{\{\$content\}\}/',
            

        ];
        $dataReplace = [
            $data['fullname'],
            $data['mobile'],
            $data['address'],
            $data['question'],
            $data['content'],
            

        ];

        $contentAdmin = preg_replace($dataFind, $dataReplace, $contentAdmin);
        $content = preg_replace($dataFind, $dataReplace, $content);

        $dataViewAdmin = [
            'content' => htmlspecialchars_decode($contentAdmin)
        ];
        $configAdmin = [
            'to' => setting_option('email_admin'),
            'subject' => "[SHUNYUAN-Admin] $subject",
        ];

        $dataView = [
            'content' => htmlspecialchars_decode($content)
        ];

        $config = [
            'to' => $data['address'],
            'subject' => "[SHUNYUAN] $subject thành công",
        ];



        $send_mail = new SendMail( 'email.content', $dataViewAdmin, $configAdmin );
        Mail::send($send_mail);

        $send_mail = new SendMail( 'email.content', $dataView, $config );
        Mail::send($send_mail);

        return redirect()->back()->with(['message' => 'Gửi thông tin liên hệ thành công!']);
    }
}
