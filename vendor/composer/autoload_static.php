<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit454cea4a6127f0fad85ee28f53d87219
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WilliamCosta\\DotEnv\\' => 20,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WilliamCosta\\DotEnv\\' => 
        array (
            0 => __DIR__ . '/..' . '/william-costa/dot-env/src',
        ),
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit454cea4a6127f0fad85ee28f53d87219::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit454cea4a6127f0fad85ee28f53d87219::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit454cea4a6127f0fad85ee28f53d87219::$classMap;

        }, null, ClassLoader::class);
    }
}
