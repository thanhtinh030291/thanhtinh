@extends('templateEmail.main')
@section('content')
  <table role="presentation" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td>&nbsp;</td>
      <td>
        <div>

          <!-- START CENTERED WHITE CONTAINER -->
          <table role="presentation">

            <!-- START MAIN CONTENT AREA -->
            <tr>
              <td>
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td>
                      <p>Dear Team,</p>
                      <p>PCV xác nhận bảo lãnh thực tế cho khách hàng  <span style="font-weight: bold">{{$data['HBS_CL_CLAIM']->MemberNameCap}}</span> với chẩn đoán ra viện {{$data['diag_text']}} tại {{$data['HBS_CL_CLAIM']->Provider->prov_name}} từ  {{$data['incurDateFrom']}} đến {{$data['incurDateTo']}} ({{$data['diffIncur']}} ngày) , số tiền: <span style="font-weight: bold">{{formatPrice($data['HBS_CL_CLAIM']->SumAppAmt)}}</span> đồng. (chi tiết như file đính kèm)
                        <span style="font-weight: bold">{{formatPrice($data['HBS_CL_CLAIM']->SumAppAmt)}}</span> đồng.</p>
                        <p class="MsoNormal"><strong><em><u><span style="font-size: 10.0pt; font-family: 'Times New Roman',serif; color: #c00000;">Lưu ý:</span></u></em></strong></p>
                        <ol style="margin-top: 0in;" start="1" type="1">
                        <li class="MsoNormal" style="color: #c00000; mso-list: l0 level1 lfo1;"><span style="font-size: 10.0pt; font-family: 'Times New Roman',serif; mso-fareast-font-family: 'Times New Roman';">PCV sẽ không thanh toán cho các hồ sơ quá hạn 30 ngày kể từ ngày xác nhận bảo lãnh chi phí thực tế.</span></li>
                        <li class="MsoNormal" style="color: black; mso-list: l0 level1 lfo1;"><span style="font-size: 10.0pt; font-family: 'Times New Roman',serif; mso-fareast-font-family: 'Times New Roman';">Và gửi toàn bộ Hồ sơ gốc có đóng dấu của bệnh viện; <strong>Giấy xác nhận của khách hàng</strong> (nếu có); tất cả chứng từ đã trao đổi qua email khi yêu cầu bảo lãnh (có đóng dấu của bệnh viện) về cho <strong>Pacific Cross Việt Nam</strong>.</span></li>
                        </ol>
                        <p class="MsoNormal" style="margin-top: 6.0pt; text-align: justify;"><strong><span style="font-size: 10.0pt; font-family: 'Times New Roman',serif; color: #c00000; mso-fareast-language: EN-GB;">Vui lòng xuất Hóa đơn GTGT theo thông tin của Dai – ichi Việt Nam:</span></strong></p>
                        <table class="MsoNormalTable" style="border-collapse: collapse; mso-yfti-tbllook: 1184; mso-padding-alt: 0in 0in 0in 0in;" border="0" cellspacing="0" cellpadding="0">
                        <tbody>
                        <tr style="mso-yfti-irow: 0; mso-yfti-firstrow: yes; height: 31.5pt;">
                        <td style="width: 118.95pt; border: solid windowtext 1.0pt; padding: 0in 5.4pt 0in 5.4pt; height: 31.5pt;" valign="top" width="159">
                        <p class="MsoNormal" style="line-height: 105%;"><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">Họ tên người mua hàng</span></p>
                        </td>
                        <td style="width: 305.9pt; border: solid windowtext 1.0pt; border-left: none; padding: 0in 5.4pt 0in 5.4pt; height: 31.5pt;" valign="top" width="408">
                        <p class="MsoNormal" style="line-height: 105%;"><strong><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">TÊN KHÁCH HÀNG</span></strong></p>
                        </td>
                        </tr>
                        <tr style="mso-yfti-irow: 1; height: 52.3pt;">
                        <td style="width: 118.95pt; border: solid windowtext 1.0pt; border-top: none; padding: 0in 5.4pt 0in 5.4pt; height: 52.3pt;" valign="top" width="159">
                        <p class="MsoNormal" style="line-height: 105%;"><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">Tên công ty</span></p>
                        </td>
                        <td style="width: 305.9pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; padding: 0in 5.4pt 0in 5.4pt; height: 52.3pt;" valign="top" width="408">
                        <p class="MsoNormal" style="line-height: 105%;"><strong><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">Công ty TNHH Bảo hiểm Nhân thọ Dai-ichi Việt Nam</span></strong></p>
                        <p class="MsoNormal" style="line-height: 105%;"><em><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">Hoặc</span></em></p>
                        <p class="MsoNormal" style="line-height: 105%;"><strong><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">Công ty Bảo hiểm Nhân thọ Dai-ichi Việt Nam</span></strong></p>
                        </td>
                        </tr>
                        <tr style="mso-yfti-irow: 2; height: 27.6pt;">
                        <td style="width: 118.95pt; border: solid windowtext 1.0pt; border-top: none; padding: 0in 5.4pt 0in 5.4pt; height: 27.6pt;" valign="top" width="159">
                        <p class="MsoNormal" style="line-height: 105%;"><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">Địa chỉ</span></p>
                        </td>
                        <td style="width: 305.9pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; padding: 0in 5.4pt 0in 5.4pt; height: 27.6pt;" valign="top" width="408">
                        <p class="MsoNormal" style="line-height: 105%;"><strong><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">149 &ndash; 151 Nguyễn Văn Trỗi, Phường 11, Q. Ph&uacute; Nhuận, TP. HCM</span></strong></p>
                        </td>
                        </tr>
                        <tr style="mso-yfti-irow: 3; mso-yfti-lastrow: yes; height: 29.8pt;">
                        <td style="width: 118.95pt; border: solid windowtext 1.0pt; border-top: none; padding: 0in 5.4pt 0in 5.4pt; height: 29.8pt;" valign="top" width="159">
                        <p class="MsoNormal" style="line-height: 105%;"><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">Mã số thuế</span></p>
                        </td>
                        <td style="width: 305.9pt; border-top: none; border-left: none; border-bottom: solid windowtext 1.0pt; border-right: solid windowtext 1.0pt; padding: 0in 5.4pt 0in 5.4pt; height: 29.8pt;" valign="top" width="408">
                        <p class="MsoNormal" style="line-height: 105%;"><strong><span style="font-size: 12.0pt; line-height: 105%; font-family: 'Times New Roman',serif; color: black;">0301851276</span></strong></p>
                        </td>
                        </tr>
                        </tbody>
                        </table>
                        <p class="MsoNormal"><span style="font-size: 12.0pt; font-family: 'Times New Roman',serif; color: red;">Vui lòng lưu ý: Mọi hình thức viết: Dai-Ichi hoặc Daiichi là chưa chính xác:</span></p>
                        <p class="MsoNormal"><span style="font-size: 12.0pt; font-family: 'Californian FB',serif; color: #1f3864;">&nbsp;</span></p>
                        <p class="MsoNormal"><span style="font-family: 'Californian FB',serif; color: black; mso-fareast-language: EN-GB;">Thanks &amp; Best Regards,</span></p>
                    </td>
                  </tr>
                </table>
              </td>
            </tr>

          <!-- END MAIN CONTENT AREA -->
          </table>
        </div>
      </td>
      <td>&nbsp;</td>
    </tr>
  </table>
@endsection
@section('old_msg')
    {!! data_get($data,'old_msg') !!}
@endsection

