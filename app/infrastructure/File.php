<?php 
declare (strict_types = 1);
namespace app\infrastructure;

class File implements IRepository
{
    private $path = '';

    public function __construct() {
        $this->path = getcwd() . DIRECTORY_SEPARATOR 
        . 'app' . DIRECTORY_SEPARATOR 
        . 'data' . DIRECTORY_SEPARATOR;
    }

    public function getAll() {
        return $this->get('key');
    }

    public function get($folder) {
        $keys = glob(
            $this->path 
            . $folder . DIRECTORY_SEPARATOR 
            . '*'
        );
        $r = array();
        foreach ($keys as $key) {
            \array_push($r, basename($key));
        }
        return $r;
    }

    public function read($folder, $file) {
        return file_get_contents(
            $this->path 
            . $folder . DIRECTORY_SEPARATOR 
            . $file
        );
    }
}
