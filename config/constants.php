<?php
return[
    'formClaimUpload'   => '/public/formClaim/',
    'formClaimStorage'  => '/storage/formClaim/',
    'formClaimSelect'   => '/public/formClaimSelect/',
    'formClaimSelectStorage'   => '/storage/formClaimSelect/',
    'formClaimExport'  => '/public/formClaimExport/',
    'formClaimExportStorage'  => '/storage/formClaimExport/',
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
        'approved' => 1,
        'dis_approve' => 2,
        'repair_completed' => 3
    ],
    'statusExportText' => [
        0 => "New",
        1 => 'Approved',
        2 => 'Dis Approved',
        3 => 'Repair Completed'
    ]
    
];