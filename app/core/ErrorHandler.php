<?php 
declare (strict_types = 1);
namespace app\core;

class ErrorHandler {
    /**
     * Shutdown function
     */
    public static function critical() {
        $error = error_get_last();
        if ($error !== NULL) {
            ErrorHandler::format(new Exception(
                'Critical Error', 
                $error["type"], 
                $error["message"], 
                $error["file"], 
                $error["line"]
            ));
        }
    }

    /**
     * Error handler
     */
    public static function error($errno, $errstr, $errfile, $errline) {
        $type = 'Unknown error';
        switch ($errno) {
            case E_ERROR:
                $type = 'Error';
                exit(1);
                break;
            case E_WARNING:
                $type = 'Warning';
                break;
            case E_PARSE:
                $type = 'Parsing Error';
                break;
            case E_NOTICE:
                $type = 'Notice';
                break;
            case E_CORE_ERROR:
                $type = 'Core Error';
                exit(1);
                break;
            case E_CORE_WARNING:
                $type = 'Core Warning';
                break;
            case E_COMPILE_ERROR:
                $type = 'Compile Error';
                exit(1);
                break;
            case E_COMPILE_WARNING:
                $type = 'Compile Warning';
                break;
            case E_USER_ERROR:
                $type = 'User error';
                exit(1);
                break;
            case E_USER_WARNING:
                $type = 'User Warning';
                break;
            case E_USER_NOTICE:
                $type = 'User Notice';
                break;
            case E_STRICT:
                $type = 'Runtime Notice';
                exit(1);
                break;
            case E_RECOVERABLE_ERROR:
                $type = 'Catchable Fatal Error';
                exit(1);
                break;
        }

        ErrorHandler::format(new Exception(
            $type, 
            $errno, 
            $errstr, 
            $errfile, 
            $errline
        ));

        return true; /* Don't execute PHP internal error handler */
    }

    public static function format(Exception $e) {
        if (Settings::DEBUG) {
            http_response_code(200); // 500
            die(json_encode((object) [
                'error' => $e
            ]));
        } else {
            new NotFound();
        }
    }
}
