<?php

namespace ZheService\ZheLb;

class config
{
    //请求地址
    const API_URL = [
        'test' =>
        [
            'PERSONAL_TICKET_URL' => 'https://ibcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220228000002/sso/servlet/simpleauth',
            'PERSONAL_USER_URL' => 'https://ibcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220228000004/sso/servlet/simpleauth',
            'LEGAL_USER_URL' => 'https://ibcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220309000001/rest/user/query',
            'SSO_TOKEN_URL' => 'https://ibcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220329000007/uc/sso/access_token',
            'SSO_USER_URL' => 'https://ibcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220329000008/uc/sso/getUserInfo',
        ],
        'live' => [
            'PERSONAL_TICKET_URL' => 'https://bcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220228000002/sso/servlet/simpleauth',
            'PERSONAL_USER_URL' => 'https://bcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220228000004/sso/servlet/simpleauth',
            'LEGAL_USER_URL' => 'https://bcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220309000001/rest/user/query',
            'SSO_TOKEN_URL' => 'https://bcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220329000007/uc/sso/access_token',
            'SSO_USER_URL' => 'https://bcdsg.zj.gov.cn:8443/restapi/prod/IC33000020220329000008/uc/sso/getUserInfo',
        ],
    ];
}
