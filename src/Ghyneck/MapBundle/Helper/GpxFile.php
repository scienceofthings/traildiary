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
     * @var GpxIngest
     */
    protected $gpxData;

    protected $latitude;

    protected $longitude;

    /*
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
        $this->gpxData = simplexml_load_file($this->file->getRealPath());
        $this->setLattitudeAndLongitude();
    }

    private function setLattitudeAndLongitude()
    {
        if($this->latitude === null || $this->longitude === null){
            $this->latitude = (string) $this->gpxData->trk[0]->trkseg[0]->trkpt[0]['lat'];
            $this->longitude = (string) $this->gpxData->trk[0]->trkseg[0]->trkpt[0]['lon'];
        }
    }

    /*
     * @return string
     */
    public function getPathNameRelativeToUploads()
    {
        $relativePath = $this->file->getPathInfo()->getFilename();
        $fileName = $this->file->getFilename();
        return $relativePath . DIRECTORY_SEPARATOR . $fileName;
    }

    /*
     * @return float
     */
    public function getLattitude()
    {
        return $this->latitude;

    }

    /*
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;

    }



}