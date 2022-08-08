<?php

namespace ZheService\ZheNm;

class Config
{
    // 浙农码token redis key
    const ZHE_NM_TOKEN_KEY = 'zhe_nm_token';

    // token过期时间
    const ZHE_NM_TOKEN_EXPIRE = '6000';

    // 善治宝--浙农码--户号的加密key
    const HOUSEHOLD_CODE_KEY = 'njl';

    // 用途代码--农户
    const USE_FOR_CODE_FARMER = '0402';

    // 二维码样式 1-简化版, 2-扩展版(外圆内方码)
    const QR_CODE_STYLE_SIMPLE = 1;
    const QR_CODE_STYLE_EXTEND = 2;

    // 码来源 1-浙农码申请 2-码备案(第三方企业接入)
    const CODE_FROM_APPLY = 1;
    const CODE_FROM_FOR_REFERENCE = 2;

    // 扩展类型 1-文件 3-单码
    const EXTEND_TYPE_FILE = 1;
    const EXTEND_TYPE_SINGLE_CODE = 3;

    // 二维码颜色 0-默认绿色 1-红 2-橙(预留,暂不支持橙色码) 3-黄
    const QR_CODE_COLOR_GREEN = 0;
    const QR_CODE_COLOR_RED = 1;
    const QR_CODE_COLOR_ORANGE = 2;
    const QR_CODE_COLOR_YELLOW = 3;

    // 浙农码--默认的尺寸大小(取值100 / 150 / 200)
    const QR_SIZE_100 = 100;
    const QR_SIZE_150 = 150;
    const QR_SIZE_200 = 200;

    // 浙农码--二维码的默认样式
    public static $znmQrCodeStyle = [
        'colorSettingMode' => 1, // 颜色设置方式 1-二维码颜色设置
        'qrCodeColor' => self::QR_CODE_COLOR_GREEN, // 二维码颜色 0-默认绿色 1-红 2-橙(预留,暂不支持橙色码) 3-黄
        'qrSize' => self::QR_SIZE_150, // 二维码尺寸
        'showRim' => 0, // 0-不显示边框,1-显示边框
    ];

    // 浙农码颜色列表
    public static $colorList = [
        self::QR_CODE_COLOR_RED, // 红
        self::QR_CODE_COLOR_YELLOW, // 黄
        self::QR_CODE_COLOR_GREEN, // 绿
    ];

    // 浙农码--浙江省行政区划分的redis的key
    const ZNM_AREA_LIST_REDIS_KEY = 'znm:zjAreaList:%s'; // %s=行政区划名称

    // 浙农码地区的前缀
    const ZNM_AREA_PREFIX = '浙江省杭州市';

    // 浙农码image中的src的base64地址的前缀
    const ZNM_IMAGE_SRC_PREFIX = 'data:image/png;base64,';

    // 浙农码--规则加减标识
    const INTEGRAL_ADD = 'add';
    const INTEGRAL_REDUCE = 'reduce';

    // 积分分界比例(用于区分浙农码颜色)
    const INTEGRAL_RATIO_DIVIDING_ONE = 1 / 3;
    const INTEGRAL_RATIO_DIVIDING_TWO = 2 / 3;

    // 浙农码--清空作废原因
    const ZNM_REMOVE_INVALID_REASON = '农户每月需重新生成新的浙农码';

    // 浙农码--将去年有强制扣分的码变成绿码的日期
    const WILL_CHANGE_GREEN_CODE_DATE = '01';

    // 浙农码--根据codeCredentials获取浙农码信息的请求url
    const ZNM_CODE_CREDENTIALS_URL = '/apiInterface/interface/hydra-code-h5/api/v1/u/resolve/url/list';

    // 浙农码--扫码类型
    const ZNM_SCAN_ENTRY_TYPE_COMMON = 'common';

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
}
