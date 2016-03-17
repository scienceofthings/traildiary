<?php
namespace Ghyneck\MapBundle\Helper;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;
use Ghyneck\MapBundle\Helper\GPXIngest;

class GpxFile
{

    /*
     * @var SplFileInfo
     */
    protected $file;

    /*
     * @var GpxIngest
     */
    protected $gpxIngest;

    /*
     * @var stdClass
     */
    protected $firstSegment;

    /*
     * @param SplFileInfo $file
     */
    public function __construct(SplFileInfo $file)
    {
        $this->file = $file;
        $this->gpxIngest = new GPXIngest();
        $this->gpxIngest->loadFile($this->file->getRealPath());
        $this->gpxIngest->ingest();
    }

    /*
     * @return stdClass
     */
    private function getFirstSegmentOfFirstTrack()
    {
        if($this->firstSegment === null){
            $idOfFirstTrack = $this->gpxIngest->getTrackIds()[0];
            $nameOfFirstSegment = $this->gpxIngest->getTrackSegmentNames($idOfFirstTrack)[0];
            $firstSegment = $this->gpxIngest->getSegment($idOfFirstTrack, $nameOfFirstSegment);
            $this->firstSegment = $firstSegment;
        }
        return $this->firstSegment;

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
     * @return string
     */
    public function getLattitude()
    {
        $firstSegment = $this->getFirstSegmentOfFirstTrack();
        $lat = $firstSegment->points->trackpt0->lat;
        return $lat;

    }

    /*
     * @return string
     */
    public function getLongitude()
    {
        $firstSegment = $this->getFirstSegmentOfFirstTrack();
        $lon = $firstSegment->points->trackpt0->lon;
        return $lon;

    }



}