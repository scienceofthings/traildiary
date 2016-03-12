<?php
namespace Ghyneck\MapBundle\Helper;

use Symfony\Component\Finder\Finder;

class DiaryFolder
{
    /*
     * @var Finder
     */
    private $diaryDirectory;

    /*
     * @param string $directory
     * @throws Exception
     */
    public function __construct($uploadDestination, $directory)
    {
        /** @var Symfony\Component\Finder\Finder diaryDirectory */
        $this->diaryDirectory = new Finder ();
        $this->diaryDirectory->files()->in($uploadDestination . DIRECTORY_SEPARATOR .$directory);
    }


    /*
     * @return string
     */
    public function getGpxFile()
    {
        $diaryDirectory = clone($this->diaryDirectory);
        $gpxFiles = $diaryDirectory->name('*.gpx');
        foreach($gpxFiles as $gpxFile){
            $diaryDirectory->name('');
            return  $gpxFile->getFilename();
        }
    }

    /*
     * @return RegexIterator
     */
    public function getImageFiles()
    {
        $diaryDirectory = clone($this->diaryDirectory);
        $imageFileIterator = $diaryDirectory->name('/\.jpe?g$/i');
        return $imageFileIterator;
    }


}