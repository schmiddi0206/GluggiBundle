<?php

namespace Becklyn\GluggiBundle\Loader;

use Symfony\Component\Asset\Packages;


/**
 * Contains a list of all CSS and JavaScript files used in the layout.
 */
class LayoutAssets
{
    /**
     * @var string[]
     */
    private $cssFiles;


    /**
     * @var string[]
     */
    private $javaScriptFiles;


    /**
     * @var Packages
     */
    private $assetsPackages;



    /**
     * @param string[] $cssFiles
     * @param string[] $javaScriptFiles
     * @param Packages $assetsPackages
     */
    public function __construct (array $cssFiles, array $javaScriptFiles, Packages $assetsPackages)
    {
        $this->assetsPackages = $assetsPackages;

        $this->cssFiles = $this->transformToUrl($cssFiles, "css");
        $this->javaScriptFiles = $this->transformToUrl($javaScriptFiles, "js");
    }



    /**
     * Transforms the paths in the config to full URLs
     *
     * @param string[] $assets
     * @param string   $directory
     *
     * @return string[]
     */
    private function transformToUrl (array $assets, string $directory) : array
    {
        return array_map(
            function (string $path) use ($directory)
            {
                if (1 === preg_match('~^(https?\\:\/)?\/~', $path))
                {
                    return $path;
                }
                else
                {
                    return $this->assetsPackages->getUrl("bundles/layout/{$directory}/{$path}");
                }
            },
            $assets
        );
    }



    /**
     * @return string[]
     */
    public function getCssUrls () : array
    {
        return $this->cssFiles;
    }



    /**
     * @return string[]
     */
    public function getJavaScriptUrls () : array
    {
        return $this->javaScriptFiles;
    }
}
