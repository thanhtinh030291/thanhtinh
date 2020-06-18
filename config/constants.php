<?php
return[
    'appName' => 'Claim Assistant',
    'appEmail' => env('MAIL_FROM_ADDRESS', 'admin@pacificcross.com.vn'),
    'appLogo'     => "/images/logo.png",
    'formClaimUpload'   => '/public/formClaim/',
    'formClaimStorage'  => '/storage/formClaim/',
    'sortedClaimUpload'   => '/public/sortedClaim/',
    'sotedClaimStorage'  => '/storage/sortedClaim/',

    'avantarUpload' => '/public/avantar/',
    'avantarStorage' => '/storage/avantar/',
    'signarureUpload' => '/public/signarure/',
    'signarureStorage' => '/storage/signarure/',
    'PUSHER_APP_KEY' => env('PUSHER_APP_KEY'),
    'PUSHER_APP_SECRET' => env('PUSHER_APP_SECRET'),
    'PUSHER_APP_ID' => env('PUSHER_APP_ID'),
    'PUSHER_APP_CLUSTER' => env('PUSHER_APP_CLUSTER'),
    'VAPID_PUBLIC_KEY' => env('VAPID_PUBLIC_KEY'),
    
    
    'paginator' => [
        'itemPerPage' => '10',
    ],
    'limit_list' => [
        10 => 10,
        20 => 20,
        30 => 30,
        40 => 40,
        50 => 50,
    ],
    'field_select' => [
        'content' => 'Content',
        'amount' => 'Amount',
    ],
    'percentSelect' => 70,

    'statusExport' => [
        'new' => 0,
        'edit' => 1,
        'note_save' => 2,
    ],
    'statusExportText' => [
        '0' => "New",
        '1' => 'Edit',
        '2' => 'Note Save',
    ],
    
    'content_ip' => [
        'ANES' => 'Chi phí phẫu thuật',
        'OPR' => 'Chi phí phẫu thuật',
        'SUR' => 'Chi phí phẫu thuật',

        'HSP' => 'Các chi phí nội trú khác, Điều trị trước và sau khi nằm viện, Phí khám bệnh hằng ngày của Bác sĩ/Bác sĩ chuyên khoa',
        'HVIS' => 'Các chi phí nội trú khác, Điều trị trước và sau khi nằm viện, Phí khám bệnh hằng ngày của Bác sĩ/Bác sĩ chuyên khoa',
        'IMIS' => 'Các chi phí nội trú khác',
        'PORX' => 'Điều trị sau khi nằm viện',
        'POSH' => 'Điều trị trước khi nằm viện',

        'RB' => 'Tiền phòng và ăn uống',

        'EXTB' => 'Giường cho người thân',

        'ICU' => 'Khoa chăm sóc đặc biệt',
        'CCU' => 'Khoa chăm sóc đặc biệt',

        'HNUR' => 'Điều dưỡng tại nhà',
        'PNUR' => 'Điều dưỡng tại nhà',

        'ER' => 'Điều trị tại phòng cấp cứu do tai nạn',

        'LAMB' => 'Chi phí xe cấp cứu',

        'DON' => 'Cấy ghép bộ phận',
        'REC' => 'Cấy ghép bộ phận',

        'CHEMO'  => 'Điều trị ung thư',
        'RADIA'  => 'Điều trị ung thư',

        'TDAM' => 'Điều trị tổn thương răng do tai nạn',
        
    ],
    'content_op' => [
        'OVRX' => 'Quyền lợi ngoại trú',
        'OV' => 'Quyền lợi ngoại trú',
        'RX' => 'Quyền lợi ngoại trú',
        'LAB' => 'Quyền lợi ngoại trú',
        'XRAY' => 'Quyền lợi ngoại trú',
        'PHYS' => 'Quyền lợi ngoại trú',
        'CHIR' => 'Quyền lợi ngoại trú',

        'ACUP' => 'Y hoc thay thế',
        'BSET' => 'Y hoc thay thế',
        'CGP' => 'Y hoc thay thế',
        'CMED' => 'Y hoc thay thế',
        'HERB' => 'Y hoc thay thế',
        'HLIS' => 'Y hoc thay thế',
        'HMEO' => 'Y hoc thay thế',
        'HYNO' => 'Y hoc thay thế',
        'OSTE' => 'Y hoc thay thế'
    ],
    // 'token_mantic' => 'ABBKcuCHfFxFw_2v_30e1aJG1xUXhd3p',
    // 'url_mantic' => 'https://health-etalk.pacificcross.com.vn/',
    // 'url_mantic_api' => 'https://health-etalk.pacificcross.com.vn/',
    // 'url_cps' => 'https://cpsdlvn.pacificcross.com.vn/index.php/',
    // 'api_cps' => 'https://cpsdlvn.pacificcross.com.vn/index.php/api/',
    // 'client_id' => 'ul-2l44e7vq-3t8m-4fqeaxi-6olcepgxweq',
    // 'client_secret' => 'ukbg95yi3ifcdjiso5rc7kcjqeetxpfv',
    // 'url_hbs' => 'http://192.168.148.3:8010/',
    //test
    'token_mantic' => 'YeT9k0PT91IQnmC5lSUpy75s63Y8uMEu',
    'url_mantic' => 'https://uat-etalk.pacificcross.com.vn/',
    'url_mantic_api' => 'https://uat-etalk.pacificcross.com.vn/',
    'url_cps' => 'http://local/pacific_project/cps_dlvn/branches/Tinh_0000561/index.php/',
    'api_cps' => 'http://local/pacific_project/cps_dlvn/branches/Tinh_0000561/index.php/api/',
    'client_id' => 'ul-2l44e7vq-3t8m-4fqeaxi-6olcepgxweq',
    'client_secret' => 'ukbg95yi3ifcdjiso5rc7kcjqeetxpfv',
    'url_hbs' => 'http://192.168.148.3:8010/',
    //end test
    'grant_type' => 'client_credentials',
    'url_query_online' => 'https://pcvwebservice.pacificcross.com.vn/bluecross/query_rest.php?id=',
    'mount_dlvn' => "http://192.168.0.235/dlvnprod/",
    'claim_result' => [
        1 => 'FULLY PAID' ,
        2 => 'PARTIALLY PAID',
        3 => 'DECLINED' 
    ],
    'statusWorksheet' => [
        0 => 'Mặc Định',
        1 => 'Yêu Cầu Hỗ trợ MD',
        2 => 'Đã Giải Quyết'
    ],

    'notifiRoleMD' => 'Medical',
    'benefit' =>[
        'ANES' => 'ANES',
        'OPR' => 'OPR',
        'SUR' => 'SUR',
        'HSP' => 'HSP',
        'HVIS' => 'HVIS',
        'IMIS' => 'IMIS',
        'PORX' => 'PORX',
        'POSH' => 'POSH',
        'RB' => 'RB',
        'EXTB' => 'EXTB',
        'ICU' => 'ICU',
        'CCU' => 'CCU',
        'HNUR' => 'HNUR',
        'PNUR' => 'PNUR',
        'ER' => 'ER',
        'LAMB' => 'LAMB',
        'DON' => 'DON',
        'REC' => 'REC',
        'CHEMO'  => 'CHEMO',
        'RADIA'  => 'RADIA',

        'TDAM' => 'TDAM',
        'OVRX' => 'OVRX',
        'OV' => 'OV',
        'RX' => 'RX',
        'LAB' => 'LAB',
        'XRAY' => 'XRAY',
        'PHYS' => 'PHYS',
        'CHIR' => 'CHIR',
        'ACUP' => 'ACUP',
        'BSET' => 'BSET',
        'CGP' => 'CGP',
        'CMED' => 'CMED',
        'HERB' => 'HERB',
        'HLIS' => 'HLIS',
        'HMEO' => 'HMEO',
        'HYNO' => 'HYNO',
        'OSTE' => 'OSTE',
        'DT/DENT' => 'DT/DENT',
        'OE1' => 'OE1',
        'DENT' => 'DENT',
    ],
    'status_mantic' =>[
        9=>'mcp_new',
        10=>'new',
        11=>'accepted',
        12=>'partiallyaccepted',
        13=>'declined',
        14=>'pending',
        15=>'reopen',
        16=>'ask_pocy_status',
        20=>'feedback',
        21=>'gop_request',
        22=>'gop_initial_approval',
        23=>'gop_wait_doc',
        30=>'acknowledged',
        40=>'confirmed',
        50=>'assigned',
        60=>'open',
        65=>'mcp_info_request',
        66=>'mcp_add_doc',
        67=>'mcp_doc_sufficient',
        68=>'mcp_hc_received',
        69=>'mcp_hc_request',
        80=>'resolved',
        89=>'mcp_closed',
        90=>'closed',
        100=>'inforequest',
        105=>'inforeceived',
        110=>'investrequest',
        115=>'askpartner',
        120=>'readyforprocess'
    ],
    'status_mantic_value' => [
        'accepted' => 11,
        'partiallyaccepted' =>12,
        'declined' => 13,
    ],
    'payment_method' =>[
        'TT' => 'Chuyển khoản qua ngân hàng',
        'CA' => 'Nhận tiền mặt tại ngân hàng',
        'CQ' => 'Nhận tiền mặt tại văn phòng',
        'PP' => 'Đóng phí bảo hiểm cho hợp đồng'
    ],
    'debt_type' =>[
        1 => 'nợ được đòi lại',
        2 => 'nợ nhưng đã cấn trừ qua Claim khác',
        3 => 'nợ nhưng khách hàng đã gửi trả lại',
        4 => 'nợ không được đòi lại',
    ],
    'tranfer_status' => [
        10	=> "DELETED",
        20	=> "NEW",
        30	=> "LEADER APPROVAL",
        50	=> "LEADER REJECTED",
        60	=> "MANAGER APPROVAL",
        80	=> "MANAGER REJECTED",
        90	=> "DIRECTOR APPROVAL",
        110	=> "DIRECTOR REJECTED",
        140	=> "DLVN CANCEL",
        145	=> "DLVN PAYPREM",
        150	=> "APPROVED",
        160	=> "SHEET",
        165	=> "SHEET PAYPREM",
        170	=> "SHEET DLVN CANCEL",
        175	=> "SHEET DLVN PAYPREM",
        180	=> "TRANSFERRING",
        185	=> "TRANSFERRING PAYPREM",
        190	=> "TRANSFERRING DLVN CANCEL",
        195	=> "TRANSFERRING DLVN PAYPREM",
        200	=> "TRANSFERRED",
        205	=> "TRANSFERRED PAYPREM",
        210	=> "TRANSFERRED DLVN CANCEL",
        215	=> "TRANSFERRED DLVN PAYPREM",
        216	=> "RETURNED TO CLAIM",
        220	=> "DLVN CLOSED",
    ],
    'claim_type'=>[
        'M' => '(Member)',
        'P' => '(GOP)',
    ],
    'status_request_gop_pay' => [
        'request' => 'Đang đợi xác nhận',
        'accept'  => 'Đã được xác nhận',
        'reject'  => 'Đã bị từ chối',
    ]
];