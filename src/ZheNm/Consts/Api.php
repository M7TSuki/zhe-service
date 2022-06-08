<?php

namespace ZheService\ZheNm\Consts;

class Api
{
    // 认证登录
    const OAUTH_TOKEN_API = '/hydra-znm-api/api/v1/oauth/token';

    //浙农码申请
    const APPLY_CODE_API = '/hydra-znm-api/api/v3/znm/code-apply';

    //批量获取二维码图片及设置预警赋色
    const BATCH_GET_QR_CODE_API = '/hydra-znm-api/api/v1/znm/getZnmQrCodeList';

    //更新赋码信息
    const UPDATE_CODE_API = '/hydra-znm-api/api/v3/update/znm-code-params';

    //扫码通过获取用户信息
    const GET_USER_BY_CODE_API = '/hydra-znm-api/api/v1/znm/code/info';

    //获取浙里办扫码人信息
    const GET_LOGIN_USER_API = '/hydra-znm-api/api/v1/znm/zww-user/login-info';

    ## 废弃
    // // 浙农码申请上传文件
    // const FILE_UPLOAD_API = '/hydra-znm-api/api/v1/file/upload';

    // // 浙农码下载
    // const CODE_DOWNLOAD_API = '/hydra-znm-api/api/v1/znm/codeDownload';

    // // 浙农码作废
    // const CODE_INVALID_API = '/hydra-znm-api/api/v1/znm/codeInvalid';

    // // 浙农码清空作废
    // const REMOVE_INVALID_CODE_API = '/hydra-znm-api/api/v1/znm/code/invalid/remove';

    // // 通过浙农码获取扩展码
    // const GET_EXTEND_CODE_BY_ZNM_API = '/hydra-znm-api/api/v1/znm/get/extend/code';

    // // 获取扩展码对应的浙农码
    // const GET_ZNM_CODE_BY_EXTEND_CODE_API = '/hydra-znm-api/api/v1/znm/getZnmCode';

    // // 获取浙农码的生码状态
    // const GET_ZNM_APPLY_STATUS_API = '/hydra-znm-api/api/v1/znm/get/apply/status';

    // // 获取某个应用(客户端)的用码/示码/扫码总数
    // const GET_ZNM_CODE_USE_RECORD_API = '/hydra-znm-api/api/v1/znm/get/code-use-record';

    // // 获取码申请记录列表
    // const GET_ZNM_CODE_RECORD_LIST_API = '/hydra-znm-api/api/v1/znm/record/page/list';

}
