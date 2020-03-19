<?php
return[
    'appName' => 'Claim Assistant',
    'appEmail' => env('MAIL_FROM_ADDRESS', 'admin@pacificcross.com.vn'),
    'appLogo'     => "/images/logo.png",
    'formClaimUpload'   => '/public/formClaim/',
    'formClaimStorage'  => '/storage/formClaim/',
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
    'token_mantic' => 'jGPFMpQK5nz5f4PRqARovKXe_W3fUoQC',
    'url_mantic' => 'http://manticdaichi.com/',
    'url_cps' => 'http://192.168.0.10/cps_dlvn/index.php/mantis/',
    'url_query_online' => 'https://pcvwebservice.pacificcross.com.vn/bluecross/query_rest.php?id=',
    'claim_result' => [
        1 => 'FULLY PAID' ,
        2 => 'PARTIALLY PAID' ,
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
    ]
];