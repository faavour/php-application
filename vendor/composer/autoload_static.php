<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit55a2751de2a805fd04cc746bb4fcef32
{
    public static $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Mac\\Lecturio2\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Mac\\Lecturio2\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit55a2751de2a805fd04cc746bb4fcef32::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit55a2751de2a805fd04cc746bb4fcef32::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit55a2751de2a805fd04cc746bb4fcef32::$classMap;

        }, null, ClassLoader::class);
    }
}
