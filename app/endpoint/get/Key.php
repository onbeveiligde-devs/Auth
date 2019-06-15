<?php 
declare (strict_types = 1);
namespace app\endpoint\get;

use app\infrastructure\{
    File
};

class Key implements \app\core\IPage {
    public function index($data = []) {
        $file = new File();
        if (isset($data[0])) {
            // Get key by filename
            $key = preg_replace("/[^.0-9a-zA-Z]+/", "", $data[0]);
            die(json_encode($file->read('key', $key)));
        } else {
            // Get list of keys
            die(json_encode($file->getAll()));
        }
    }

    public function public($data = []) {
        $this->index($data);
    }
}
