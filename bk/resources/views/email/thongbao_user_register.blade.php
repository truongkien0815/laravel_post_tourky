<table cellspacing="0" cellpadding="0" border="0" height="100%" width="100%">
   <tbody>
      <tr>
         <td align="center" valign="top" style="padding:20px 0 20px 0">
            <table bgcolor="FFFFFF" cellspacing="0" cellpadding="10" border="0" width="650" style="border:1px solid #e0e0e0">
               <tbody>
                  <tr>
                     <td valign="top">
                        <h1 style="font-size:22px;font-weight:normal;line-height:22px;margin:0 0 11px 0">Thành viên đăng ký mới, <span style="color: #F04F32">{{$user->name}}</span></h1>
                        <p style="font-size:12px;line-height:16px;margin:0 0 8px 0">Cảm ơn bạn đã đăng ký thành viên tại website {{$url_web}}.</p>
                        <p style="font-size:12px;line-height:16px;margin:0 0 3px 0">Thông tin tài khoản:</p>
                        <ul style="margin-top: 0;">
                           <li>Tên: {{$user->name}}</li>
                           <li>Email: <strong>{{$user->email}}</strong></li>
                           <li>Số điện thoại: <strong>{{$user->phone}}</strong></li>
                           <li>Địa chỉ: <strong>{{$user->address}}, {{$user->district}}, {{$user->province}}</strong></li>
                        </ul>
                     </td>
                  </tr>
               </tbody>
            </table>
         </td>
      </tr>
   </tbody>
</table>