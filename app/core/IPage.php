<?php 
declare (strict_types = 1);
namespace app\core;

interface IPage {
    public function index($data = []);
}
