<?php 
declare (strict_types = 1);
namespace app\endpoint\post;

class Signature implements \app\core\IPage {
    public function index($data = []) {
        if (!isset($_FILES['signatures'])) {
            new \app\model\ExpectationFailed();
        }
        
        foreach ($_FILES["signatures"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["signatures"]["tmp_name"][$key];
                move_uploaded_file($tmp_name, 
                getcwd() . DIRECTORY_SEPARATOR 
                    . 'app' . DIRECTORY_SEPARATOR 
                    . 'data' . DIRECTORY_SEPARATOR
                    . 'signature' . DIRECTORY_SEPARATOR
                    . preg_replace("/[^.0-9a-zA-Z]+/", "", 
                        basename($_FILES["signatures"]["name"][$key])
                    )
                    . '.sha256'
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
