<?php

namespace Ghyneck\MapBundle\Twig;


class MapExtensions extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('getFileName', array($this, 'getFileName')),
        );
    }

    /*
     * Extracts the part of an url which comes after the last slash (filename)
     *
     * @param string $url
     */
    public function getFileName($uri)
    {
        $path = parse_url($uri, PHP_URL_PATH);
        if($path === false){
            return "";
        }
        return basename($path);
    }

    public function getName()
    {
        return 'app_extension';
    }

}