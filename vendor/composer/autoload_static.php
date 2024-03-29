<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1f939568bb2db2d6d617e7dd57ff7e14
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit1f939568bb2db2d6d617e7dd57ff7e14::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit1f939568bb2db2d6d617e7dd57ff7e14::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit1f939568bb2db2d6d617e7dd57ff7e14::$classMap;

        }, null, ClassLoader::class);
    }
}
