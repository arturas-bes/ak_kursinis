<?php


namespace App\Utilities;


use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class Uploader
{
    private $targetDirectory;
    public $file;

    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload($file)
    {
        $video_number = random_int(1, 10000000);
        $fileName = $video_number . '.' . $file->guessExtension();
        try {

            $file->move($this->getTargetDirectory(), $fileName);

        } catch (FileException $e) {
            exit('cannot upload file'.$e);
        }
        $original_file_name = $this->clear(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        return [$fileName, $original_file_name];
    }

    public function delete($path)
    {
        $fileSystem = new Filesystem();
        try {
            $fileSystem->remove('.' . $path);
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while deleting a file at " . $exception->getPath();
        }
        return true;
    }

    private function getTargetDirectory()
    {

        return $this->targetDirectory;
    }

    private function clear($string)
    {
        $string = preg_replace('/[^A-Za-z0-9- ]+/', '', $string);
        return $string;
    }
}