<?php 
declare (strict_types = 1);
namespace app\endpoint\post;

use app\core\{
    IPage
};
use app\model\{
    ExpectationFailed,
    Openssl
};

class Key implements IPage {
    /**
     * upload new public key
     */
    public function index($data = []) {
        if (!isset($_FILES['keys'])) {
            die(json_encode(get_class_methods($this)));
        }

        foreach ($_FILES["keys"]["error"] as $key => $error) {
            if ($error == UPLOAD_ERR_OK) {
                $tmp_name = $_FILES["keys"]["tmp_name"][$key];
                move_uploaded_file($tmp_name, 
                    getcwd() . DIRECTORY_SEPARATOR 
                    . 'app' . DIRECTORY_SEPARATOR 
                    . 'data' . DIRECTORY_SEPARATOR
                    . 'key' . DIRECTORY_SEPARATOR
                    . preg_replace("/[^.0-9a-zA-Z]+/", "", 
                        basename($_FILES["keys"]["name"][$key])
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

    /**
     * decrypt data with public key
     */
    public function decrypt($data = []) {
        if (!isset($_POST['key']) || !isset($_POST['data'])) {
            die(json_encode((object) [
                'expected' => [
                    'key' => '',
                    'data' => ''
                ],
                'post' => $_POST,
                'data' => $data
            ]));
        }

        $rsa = new Openssl();
        $r = $rsa->decrypt(
            preg_replace("/[^.0-9a-zA-Z]+/", "", $_POST['key']),
            preg_replace("/[^.0-9a-zA-Z]+/", "", $_POST['data'])
        );
        die(json_encode((object) [
            'result' => $r,
            'error' => [
                'type' => ($r->ok ? 'OK' : 'Fail'),
                'message' => ($r->ok ? 'Decrypted' : 'Decrypting failed')
            ]
        ]));
    }

    /**
     * encript data with public key
     */
    public function encript($data = []) {
        if (!isset($_POST['key']) || !isset($_POST['data'])) {
            die(json_encode((object) [
                'expected' => [
                    'key' => '',
                    'data' => ''
                ],
                'post' => $_POST,
                'data' => $data
            ]));
        }
        
        $rsa = new Openssl();
        $r = $rsa->encript(
            preg_replace("/[^.0-9a-zA-Z]+/", "", $_POST['key']),
            preg_replace("/[^.0-9a-zA-Z]+/", "", $_POST['data'])
        );
        die(json_encode((object) [
            'result' => $r,
            'error' => [
                'type' => ($r->ok ? 'OK' : 'Fail'),
                'message' => ($r->ok ? 'Encripted' : 'Encripting failed')
            ],
        ]));
    }

    /**
     * Verify Digital Signature
     */
    public function verify($data = []) {
        if (!isset($_POST['key']) || !isset($_POST['data'])) {
            die(json_encode((object) [
                'expected' => [
                    'key' => '',
                    'data' => ''
                ],
                'post' => $_POST,
                'data' => $data
            ]));
        }
        
        $rsa = new Openssl();
        $r = $rsa->verify(
            preg_replace("/[^.0-9a-zA-Z]+/", "", $_POST['key']),
            preg_replace("/[^.0-9a-zA-Z]+/", "", $_POST['data'])
        );
        die(json_encode((object) [
            'result' => $r,
            'error' => [
                'type' => ($r->ok ? 'OK' : 'Fail'),
                'message' => ($r->ok ? 'verified' : 'verifying failed')
            ]
        ]));
    }
}
