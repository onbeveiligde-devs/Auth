<?php 
declare (strict_types = 1);
namespace app\core;

class Exception {
    public $type = "PHP Exception";
    public $no = E_CORE_ERROR;
    public $str = "shutdown";
    public $file = "unknown file";
    public $line = 0;

    public function __construct(
        $type = "PHP Exception",
        $no = E_CORE_ERROR,
        $str = "shutdown",
        $file = "unknown file",
        $line = 0
    ) {
        $this->type = $type;
        $this->no = $no;
        $this->str = $str;
        $this->file = $file;
        $this->line = $line;
    }
}
