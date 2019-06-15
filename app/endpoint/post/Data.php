<?php 
declare (strict_types = 1);
namespace app\endpoint\post;

class Data implements \app\core\IPage {
    public function index($data = []) {
        if (!isset($_FILES['files'])) {
            new \app\model\ExpectationFailed();
        }
        
        foreach ($_FILES["files"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["files"]["tmp_name"][$key];
                move_uploaded_file($tmp_name, 
                    getcwd() . DIRECTORY_SEPARATOR 
                    . 'app' . DIRECTORY_SEPARATOR 
                    . 'data' . DIRECTORY_SEPARATOR
                    . 'data' . DIRECTORY_SEPARATOR
                    . preg_replace("/[^.0-9a-zA-Z]+/", "", 
                        basename($_FILES["files"]["name"][$key])
                    )
                );
            }
        }

        die(json_encode((object) [
            'error' => [
                'type' => 'OK',
                'message' => 'Saved'
            ],
        ]));
    }
}
