<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdc5dd8d37f7de06c17d849b6172c3c4d
{
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
            $loader->prefixLengthsPsr4 = ComposerStaticInitdc5dd8d37f7de06c17d849b6172c3c4d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdc5dd8d37f7de06c17d849b6172c3c4d::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
