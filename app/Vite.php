<?php

namespace Practice\Task;

class Vite
{
    protected static $moduleScripts = [];
    protected static $resourceURL = 'http://localhost:9999/resources/';
    protected static $assetsURL = PR_ADDRESS_PLUGIN_URL . 'assets/';
    protected static $directoryURL = PR_ADDRESS_PLUGIN_DIR;

    private static function isDev()
    {
        return true;
    }

    public static function enqueueScript($handle, $src, $dependency = [], $version = false, $inFooter = false)
    {
        static::$moduleScripts[] = $handle;
        $src                      = static::generateSrc($src);
        wp_enqueue_script($handle, $src, $dependency, $version, $inFooter);
        static::addModuleToScript();
    }

    public static function enqueueStyle($handle, $src, $dependency = [], $version = false, $media = 'all')
    {
        $src = static::generateSrc($src);
        wp_enqueue_style($handle, $src, $dependency, $version, $media);
    }

    public static function enqueueStaticScript($handle, $src, $dependency = [], $version = false, $inFooter = false)
    {
        $src = static::getStaticSrcUrl($src);
        wp_enqueue_script($handle, $src, $dependency, $version, $inFooter);
    }

    public static function enqueueStaticStyle($handle, $src, $dependency = [], $version = false, $media = 'all')
    {
        $src = static::getStaticSrcUrl($src);
        wp_enqueue_style($handle, $src, $dependency, $version, $media);
    }

    private static function parseManifest()
    {
        if (file_exists($manifestPath = static::$directoryURL . 'assets/manifest.json')) {
            return json_decode(
                file_get_contents($manifestPath),
                true
            ); //phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
        } else {
            throw new \Exception('Manifest file not found please build your assets first.');
        }
    }

    private static function addModuleToScript()
    {
        add_filter('script_loader_tag', function ($tag, $handle, $src) {
            if (in_array($handle, static::$moduleScripts)) {
                return wp_get_script_tag(
                    [
                        'id'   => "$handle-js",
                        'src'  => esc_url($src),
                        'type' => 'module'
                    ]
                );
            }

            return $tag;
        }, 10, 3);
    }

    private static function generateSrc($src)
    {
        if (!static::isDev()) {
            $manifest = static::parseManifest();
            $src      = 'resources/' . $src;
            $mainSrc  = isset($manifest[$src]) ? $manifest[$src] : false;
            if ($mainSrc) {
                if (isset($mainSrc['css'])) {
                    foreach ($mainSrc['css'] as $css) {
                        wp_enqueue_style($css . '_css', static::$assetsURL . $css, [], '1.0.0', 'all');
                    }
                }

                return static::$assetsURL . $manifest[$src]['file'];
            }
        } else {
            return static::$resourceURL . $src;
        }
    }

    public static function getStaticSrcUrl($src)
    {
        if (!static::isDev()) {
            return static::$assetsURL . $src;
        } else {
            return static::$resourceURL . $src;
        }
    }

    public static function getAssetsUrl()
    {
        if (!static::isDev()) {
            return static::$assetsURL;
        } else {
            return static::$resourceURL;
        }
    }
}
