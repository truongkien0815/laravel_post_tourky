<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Mail\SendMail;




class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function userCan($action, $option = NULL)
    {
        $user = Auth::user();
        return Gate::forUser($user)->allows($action, $option);
    }
    public function index()
    {
        // if (!$this->userCan('view-page-admin')) {

        //     abort('403', __('Bạn không có quyền thực hiện thao tác này'));
      
        // }
     
        $contact = \App\Contact::orderBy('created_at','desc')->get();
       
        return view('admin/contact')->with('contact',$contact);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $question = \App\Question::orderBy('created_at','desc')->get();
        return view('admin/contact_add')->with('question',$question);
    }
    public function addcontact()
    {
        
        // if (!$this->userCan('view-page-admin')) {

        //     abort('403', __('Bạn không có quyền thực hiện thao tác này'));
      
        // }
      
        return view('admin/contact_add');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if (!$this->userCan('view-page-admin')) {

        //     abort('403', __('Bạn không có quyền thực hiện thao tác này'));
      
        // }

        $item = new \App\Contact;
       
        $item->address = $request->diachi_lienhe;
       
        $item->content = $request->noidung_lienhe;
      
        $item->mobile =  $request->dienthoai_lienhe;
        $item->fullname =  $request->ten_lienhe;
        $item->question_id =  $request->question_id;

        
        $item->save();
        // $product = Product::all();
        $contact = \App\Contact::orderBy('created_at','desc')->get();
        // $type = Type::all();
        // $protypes = Protype::all();
        return view('admin/contact')->with('contact',$contact);
    }

    public function story(Request $request)
    {
        $item = new \App\Contact;
       
        $item->address = $request->address;
      
        $item->content = $request->content;
     
        $item->mobile =  $request->mobile;
        $item->fullname =  $request->fullname;
        $item->question_id =  $request->question;
        $item->save();
       
         Session()->flash('success_lienhe', ' Đã gửi thông tin liên hệ thành công');
         return redirect()->back();
       



        ;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // if (!$this->userCan('view-page-admin')) {

        //     abort('403', __('Bạn không có quyền thực hiện thao tác này'));
      
        // }
        $item = \App\Contact::find($id);

        $question = \App\Question::orderBy('created_at','desc')->get();
       
        return view('admin/contact_edit')->with('item', $item)->with('question', $question);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $item = \App\Contact::find($id);
        $item->address = $request->diachi_lienhe;
      
        $item->content = $request->noidung_lienhe;
       
        $item->mobile =  $request->dienthoai_lienhe;
        $item->fullname =  $request->ten_lienhe;
        $item->question_id =  $request->question_id;
        $item->save();
        $contact = \App\Contact::orderBy('created_at','desc')->get();
        return view('admin/contact')->with('contact',$contact);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // if (!$this->userCan('view-page-admin')) {

        //     abort('403', __('Bạn không có quyền thực hiện thao tác này'));
      
        // }
        $item = \App\Contact::find($id);
        $item->delete();
        return redirect()->back();
    }

    public function send_mail(Request $request)
    {
        $fullname =$request->fullname;
        $mobile =$request->mobile;
        $address = $request->address;
        $question = $request->question;
        $content = $request->content;

        
        $this->data['fullname'] =$fullname;
        $this->data['mobile'] =$mobile;
        $this->data['address'] =$address;
        $this->data['content'] =$content;
        $this->data['question_id'] =$question;
        \Mail::to('truongkien0815@gmail.com', 'hii')->send(new SendMail($this->data));
        return redirect()->back();


//         $to = 'truongkien0815@gmail.com'; // Địa chỉ email người nhận
//         $subject = 'Chủ đề email';
//         $message = 'Nội dung email';

//         // Mail::to($to)->send(new \App\Mail\SendMail($subject, $message));
//   \Mail::to($to)->send(new \App\Mail\SendMail(['subject', $message]));

//         return redirect()->back()->with('success', 'Email đã được gửi đi!');





//   $data= $request->all();
//   $emails = $data['emails']??'';

//   \Mail::to('truongkien0815@gmail.com')->send(new \App\Mail\SendMail(['emails'=> $emails]));
//   Session::flash('flash_message','thành công');

//   return view('theme.page.tuyen-dung');


  
    }
}
