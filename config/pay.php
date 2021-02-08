<?php
return [
    'alipay' => [
        'app_id' => '2016080400168772',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAtiJfI7CEfRac49wtFiGbllJJgnCc8QNGFN3XHdmvm3M6T6V/la6UWgJfZhb7PADqYVm+nI6KylFfBaoLbM2yTudP336A42WcgzcLvqsMJ/mlhi5lud5U9UbG81z2Es3Ud71ubw/DyoAvbJMXxQLmzyXrIeOJWz6xDS3sD06ovJ4SvvtTOLgtkxY2DBufguHOJITD4543yf3AgbrR8C4pbJMrr3NJ+QFZzne3lVvuKk/vfSocWSXXOnRLH/Gtyx2OZJXmGUsjFz/3Q796vxA6aTrJp82Ter4SNPBIGgz5iqnkSVHM/MvmaxyINsQCfmTt6gw0a0VucKGidzlK8WzG5QIDAQAB',// 支付宝公钥
        'private_key' => 'MIIEpAIBAAKCAQEAm1JBEm3scOejiwEOL5v2nHyoKdQvWQfhEwAYqICihzF7rP7r7yQMQ+FhNcunCGKiUOsCF+E+ebe7YtpnwtdcU6lcpGgkYD1u5ITCaK9Dd0QWwwo08HzNqIkN/xR49RvX1ENUzh8AiEHLF0kET+Yzoz1y+oYpFVKtddlZskoMQOhNw6nE9HR8qFY+sg72cP8wEHEkIC6GevWE8XYEyFoW9SqWJlp1qmXCn7hoPf9/ikFCHK0cqlSUuc2/lEVPyuA3Ux7BOgdZbSN48PtkuUN1fLnwldKFusiOQNU6kszbb4EElOoBfU/36R8XKhSaRWYGoTceB9a0zp8+XI7UNYNYJQIDAQABAoIBAQCQcqXL0ukCc5qYCso7oqtuC0yFYi0KepZqijtkcgU0/+MKFyYqh/bUJkW2twhHdxuHb5fJx5PHtQSTQZUgEhNuRuK+j4/M5TU9Vu5KVzzCLVOR3eswAJFu/M9Ee7CmG1fUsy2qaBChp7aNmD1nZSp+1QYaUSziBLsHD7UoZ08QCMSsRgE1zNj33VxeQOAR1xRozpsQ00D/ZSrMV2yyjO5FpsrITEBPWDSpMlzvh0z6+ds6kVjmPWEjiT4aLSXIKCeC3NoEG1HDrVxb2d5OJLpNXjG3NrzOGGTI/hsJqBr1XycSZQeIuX1FSLrdFEE5ZKUxuXhyE59LGhJyrWO+jvsdAoGBAOXYiv2uNct37lo/IrVQZ9fG0+jm5fQXjfMO4fjB50+6lxhfDZUUFkG9S7dMMLPWgGFg6Z+K85JFGJ+TOg+IIayUVOZ3brC5/0l1kpx+nYkllHizvJLmaxJ2ODcSSLUECDSBbGlU5n4KivFrNIacFYrkKXIEoZrte3RGT+v1WtYzAoGBAKz+y6Qj6GHtfZPDmZRxv1neCJb/PkpX2m26MkLdEKUNozgoxmRFNdX3hsUW3qH1hotOrU0ZTeJkRCYPHi1s8+UM2j16d/CQ1mfJCXyR+8LxSNAaZorkK3jNsDihuyZIjPwSPzVnK/r/h48InTUzpCZHbE+UdJT0sc4sviwqFlBHAoGBAMAJIHe7ai7J0VeNkI40084wzTS2VkKOu4bsVFjmiUDQARXXtR1tXvsmEXDgM4DOIw05T3iBO+hl2qDY/ZWkg54RgK3d85msjWLu3MPr9et0fowqf8+svKD8LRO2LxEugTx9Nfr7eGiunk/+5i/hkQ4ue4JL5EnxSUhoxrW6lV6JAoGAYd2GsKXLqdKjjvtBn9O1j45nR5y/zWjj3d1O37qV1vnfEz8l9MWejhwItuiYLAFtCtQIgCxHfkKAtxMoXERduX9K2yq0PXiCgpYdcsZXKdI8AdZdmkc4PJAIGBGOgTrb3yIndfuWytjSBF24Kce8Hhebs21lgnrnN57iOrPYibMCgYB/TmSYaXej9ovR94QusrhJNZnedjG9yCI9WyTPrwqyXsjZyFipgLNKre0THp9yTmFzKlob/vzELJDgOF+ZdJsecj6UGX8KwiWaZMzEy3vu+G3ciQt5pc1xY3q0JFGjywx8p5Mwt2qkpx8KgBMHuuvoPBUrKSIx0PL80dkrdgvSlQ==',// 应用私钥
        'log' => [
            'file' => storage_path('logs/alipay.log')
        ],
    ],
    'wechat' => [
        'app_id' => '',
        'mch_id' => '',
        'key' => '',
        'cert_client' => '',
        'cert_key' => '',
        'log' => [
            'file' => storage_path('logs/wechat_pay.log')
        ],
    ],
];
