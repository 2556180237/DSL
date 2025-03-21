<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitdfd6cb8c6cdd0176e2150c0d0f7b6ae6
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        spl_autoload_register(array('ComposerAutoloaderInitdfd6cb8c6cdd0176e2150c0d0f7b6ae6', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitdfd6cb8c6cdd0176e2150c0d0f7b6ae6', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitdfd6cb8c6cdd0176e2150c0d0f7b6ae6::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
