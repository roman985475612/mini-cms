<?php declare(strict_types=1);

namespace Home\CmsMini\Core;

use Home\CmsMini\Db\Connection;
use Exception;
use stdClass;

class Console
{
    public static $config;

    protected $argc;

    protected $argv;
    
    protected $arguments;

    public function __construct()
    {
        try {
            self::$config = json_decode(file_get_contents(dirname(__DIR__, 2) . '/config/config.json'));
            
            Connection::init(
                self::$config->db->dsn,
                self::$config->db->user,
                self::$config->db->pass
            );

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
        switch ($argument) {
            case 'migrate': 
                return \Home\CmsMini\Db\Migration::class;
        }
    }
}
