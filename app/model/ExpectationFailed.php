<?php 
declare (strict_types = 1);
namespace app\model;

class ExpectationFailed implements \app\core\IPage {
    public function __construct($data = [])
    {
        $this->index($data);
    }

    public function index($data = [])
    {
        http_response_code(417);
        die(json_encode((object) [
            'error' => [
                'type' => 'User error',
                'message' => 'Expectation Failed',
                'post' => $_POST,
                'data' => $data
            ],
        ]));
    }
}
