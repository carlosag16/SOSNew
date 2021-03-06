<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4d90ea0440e21d31557877dc9c13617d
{
    public static $files = array (
        '86264d54fd0a914782b3c2259727db7b' => __DIR__ . '/../..' . '/app/functions/caminhos_conf.php',
        '08553373174aed5b2079e6334c2d2257' => __DIR__ . '/../..' . '/app/functions/custom.php',
        '0c48edfd83033889f779790f8f59dd48' => __DIR__ . '/../..' . '/app/functions/pages.php',
        '1a034cec71159224725114f89a820cf1' => __DIR__ . '/../..' . '/app/functions/validate.php',
        '832debbbcfeab8700db6cef00613e4fc' => __DIR__ . '/../..' . '/app/functions/email.php',
    );

    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4d90ea0440e21d31557877dc9c13617d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4d90ea0440e21d31557877dc9c13617d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
