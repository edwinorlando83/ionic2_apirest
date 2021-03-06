<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInite01fbdd38d6c72ae4d282fa4a6d9b6f9
{
    public static $files = array (
        'fa3df3013f51e030ec6f48c5e17462d5' => __DIR__ . '/..' . '/lindelius/php-jwt/src/functions.php',
    );

    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Lindelius\\JWT\\' => 14,
        ),
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Lindelius\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/lindelius/php-jwt/src',
        ),
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInite01fbdd38d6c72ae4d282fa4a6d9b6f9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInite01fbdd38d6c72ae4d282fa4a6d9b6f9::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
