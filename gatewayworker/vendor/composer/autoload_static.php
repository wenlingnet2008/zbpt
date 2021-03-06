<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4d81e78d0e31e3b63a4be23f2d15c721
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
        'G' => 
        array (
            'GatewayWorker\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
        'GatewayWorker\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/gateway-worker/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4d81e78d0e31e3b63a4be23f2d15c721::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4d81e78d0e31e3b63a4be23f2d15c721::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
