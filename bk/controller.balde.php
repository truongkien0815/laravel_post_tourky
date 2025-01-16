$data = request()->all();
        $file_path = '/upload/recruitment/';

        $file_cv = request()->file('file_cv');
        $attach = [];
        if($file_cv)
        {
            // dd(public_path().$file_path);
            $file_name = time() . '-' . $file_cv->getClientOriginalName();
            $file_name_path = $file_path . $file_name;
            $file_cv->move( public_path().$file_path, $file_name );

            $attach['fileAttach'][] = [
                    'file_path' => url($file_name_path),
                    'file_name' => $file_name
            ];
        }


        $subject = 'Gửi thông tin tuyển dụng';
        \App\Model\Contact::create([
            'file'  => $file_name??'',
            'name'  => $data['fullname']??'',
            'email'  => $data['mail']??'',
            'phone'  => $data['phone']??'',
            'subject'  => $subject,
            'content'  => $subject,
        ]);

        $emailContentAdmin = ShopEmailTemplate::where('group', 'recruitment_admin')->first();
        $emailContent = ShopEmailTemplate::where('group', 'recruitment_user')->first();

        $contentAdmin = $emailContentAdmin->text;
        $content = $emailContent->text;

        $dataFind = [
            '/\{\{\$userName\}\}/',
            '/\{\{\$userPhone\}\}/',
            '/\{\{\$userEmail\}\}/',
        ];
        $dataReplace = [
            $data['fullname'],
            $data['phone'],
            $data['mail'],
        ];

        $contentAdmin = preg_replace($dataFind, $dataReplace, $contentAdmin);
        $content = preg_replace($dataFind, $dataReplace, $content);

        $dataViewAdmin = [
            'content' => htmlspecialchars_decode($contentAdmin)
        ];
        $configAdmin = [
            'to' => setting_option('email'),
            'subject' => "[EVAS-Admin] $subject",
        ];

        $dataView = [
            'content' => htmlspecialchars_decode($content)
        ];

        $config = [
            'to' => $data['mail'],
            'subject' => "[EVAS] $subject thành công",
        ];



        $send_mail = new SendMail( 'email.content', $dataViewAdmin, $configAdmin, $attach );
        Mail::send($send_mail);

        $send_mail = new SendMail( 'email.content', $dataView, $config, $attach );
        Mail::send($send_mail);

        return redirect()->back()->with(['message' => 'Gửi thông tin tuyển dụng thành công!']);
    }