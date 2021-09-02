<?php declare(strict_types=1);

namespace Home\CmsMini\Core;

use Exception;
use stdClass;

class Console
{
    protected $argc;

    protected $argv;
    
    protected $arguments;

    public function __construct()
    {
        try {
            $this->argc = $_SERVER['argc'];
            $this->argv = $_SERVER['argv'];

            $this->setArguments();
            $this->dispatch();
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }
    }

    protected function setArguments()
    {
        $this->arguments = new stdClass;
        
        if ($this->argc < 2) {
            throw new Exception('No arguments!');
        }

        $command = explode(':', $this->argv[1]);

        switch (count($command)) {
            case 1:
                $this->arguments->class = $command[0]; 
                $this->arguments->method = 'default'; 
                break;

            case 2:
                $this->arguments->class = $command[0]; 
                $this->arguments->method = $command[1]; 
                break;
        }

        $this->arguments->params = [];
        if ($this->argc > 2) {
            $params = array_slice($this->argv, 2, $this->argc - 2);

            foreach ($params as $item) {
                $item = ltrim($item, '--');
                $item = explode('=', $item);
                $this->arguments->params[$item[0]] = $item[1];
            }
        }
    }

    protected function dispatch()
    {
//        $class = match ($this->arguments->class) {
//            'migrate' => \Home\CmsMini\Db\Migration::class,
//        };

        $class = $this->match($this->arguments->class);

        if (!class_exists($class)) {
            throw new Exception('No class!');
        }

        $controller = new $class;
        if (!method_exists($class, $this->arguments->method)) {
            throw new Exception('No method');
        }

        call_user_func_array([$controller, $this->arguments->method], $this->arguments->params);
    }

    protected function match($argument)
    {
        switch ($this->arguments->class) {
            case 'migrate': return \Home\CmsMini\Db\Migration::class;
        }
    }
}
