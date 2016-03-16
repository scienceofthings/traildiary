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
     * @param \SplFileInfo $directory
     */
    public function __construct(\SplFileInfo $directory)
    {
        /** @var Symfony\Component\Finder\Finder diaryDirectory */
        $this->diaryDirectory = new Finder();
        $this->diaryDirectory->files()->in($directory->getPath());
    }


    /*
     * @return SplFileInfo
     */
    public function getGpxFile()
    {
        $diaryDirectory = clone($this->diaryDirectory);
        $gpxFiles = $diaryDirectory->name('*.gpx')->getIterator();
        $gpxFiles->rewind();
        $firstMatchingFile = $gpxFiles->current();
        return $firstMatchingFile;
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


    /*
     * @return SplFileInfo
     */
    public function getDescriptionFile()
    {
        $diaryDirectory = clone($this->diaryDirectory);
        $descriptionIterator = $diaryDirectory->name('/\.md$/i')->getIterator();
        $descriptionIterator->rewind();
        $firstMatchingDescriptionFile = $descriptionIterator->current();
        return $firstMatchingDescriptionFile;
    }


}