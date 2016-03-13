<?php
namespace Ghyneck\MapBundle\Helper;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class DescriptionFile
{

    /*
     * @var splFileInfo
     */
    private $descriptionFile;

    /*
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->descriptionFile = $file;

    }

    /*
     * @return string
     */
    public function getDescriptionAsHtml()
    {
        $rawDescription = $this->descriptionFile->getContents();
        return $rawDescription;

    }

}