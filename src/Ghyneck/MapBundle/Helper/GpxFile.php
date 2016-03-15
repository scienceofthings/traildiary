<?php
namespace Ghyneck\MapBundle\Helper;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class GpxFile
{

    /*
     * @var SplFileInfo
     */
    protected $file;

    /*
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
    }

    /*
     * @return string
     */
    public function getPathName()
    {
        return $this->file->getRealPath();
    }

    /*
     * @return string
     */
    public function getLattitude()
    {
        return "lat";

    }

    /*
     * @return string
     */
    public function getLongitude()
    {
        return "lon";

    }



}