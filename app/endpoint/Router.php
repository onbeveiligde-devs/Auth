<?php
declare (strict_types = 1);
namespace app\endpoint;

class Router
{
    private $path;
    private $namespace = 'app\core';
    private $controller = 'NotFound';
    private $methode = 'index';
    private $parameters = [];

    public function __construct(
        string $path,
        string $namespace = '',
        string $controller = ''
    ) {
        $this->path = $path;
        if (!empty($namespace)) {
            $this->namespace = $namespace;
        }
        if (!empty($controller)) {
            $this->controller = $controller;
        }
    }

    public function setNamespace(string $namespace): void {
        $this->namespace = $namespace;
    }

    public function parseUrl()
    {
        if (isset($_GET['r'])) {
            $url = explode('/', $_GET['r']);

            if (isset($url[0]) && $url[0] == '') {
                unset($url[0]);
            }

            return array_values($url);
        }
    }

    /**
     * routed the sitepages
     * http(s)://www.example.com/classname/methodname/attribute1/attribute2/etc
     */
    public function route(array $url = [])
    {
        // controleer of de opgegeven controller bestaat
        if (isset($url[0]) && $url[0] != '') {
            $this->controller = ucfirst(strtolower($url[0]));
            unset($url[0]);
        }

        // controleer of de parameter bestaat
        if (isset($url[1])) {
            $this->methode = strtolower($url[1]);
            unset($url[1]);
        }

        // sla de parameters op
        $this->parameters = $url ? array_values($url) : [];
    }

    public function run()
    {
        $c = $this->namespace . $this->controller;
        $c = str_replace(['/', DIRECTORY_SEPARATOR], "\\", $c);
        $o = new $c;
        $m = $this->methode;

        if (method_exists($o, $m)) {
            $o->$m($this->parameters);
        } else {
            new \app\core\NotFound();
        }
    }

    public function find(): bool
    {
        return file_exists(
            getcwd() . 
            DIRECTORY_SEPARATOR . 
            str_replace("\\", DIRECTORY_SEPARATOR, $this->namespace) . 
            $this->controller . '.php');
    }
}
