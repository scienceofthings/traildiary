<?php
namespace Ghyneck\MapBundle\Helper;

use Symfony\Component\Finder\Finder;

class DiariesFolder
{

    /*
     * @var string
     */
    private $diariesDirectory;

    /*
     * @param string $absolutePathToDiaries
     */
    public function __construct($absolutePathToDiaries)
    {
        $this->diariesDirectory = $absolutePathToDiaries;
    }

    /*
     * @return param Finder
     */
    public function getDiaryFolders()
    {
        $diaryDirectories = new Finder ();
        $diaryDirectories->directories()->in($this->diariesDirectory)->depth('< 1');
        return $diaryDirectories;
    }

}