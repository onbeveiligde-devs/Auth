<?php 
declare (strict_types = 1);
namespace app\core;

class NotFound implements IPage {
    public function __construct()
    {
        $this->index();
    }

    public function index($data = [])
    {
        http_response_code(404);
        die(json_encode((object) [
            'error' => [
                'type' => 'User error',
                'message' => 'Not Found'
            ],
        ]));
    }
}
