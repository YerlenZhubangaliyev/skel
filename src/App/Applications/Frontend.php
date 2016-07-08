<?php
namespace App\Applications;

use App\Application as BaseApplication;
use App\Bootstrap;
use App\Helper\Path as HelperPath;
use App\Vendor\Phalcon\Error;
use Composer\Autoload\ClassLoader;
use Phalcon\Mvc\Application as PhalconApplication;
use Phalcon\Di;

/**
 * Frontend initialization
 */
class Frontend extends BaseApplication
{

    /**
     * Constructor
     *
     * @param \Composer\Autoload\ClassLoader $loader
     */
    public function __construct(ClassLoader $loader)
    {
        if (!defined('ENVIRONMENT')) {
            print("Environment must be defined");
            exit(1);
        }

        if (!defined('APPLICATION')) {
            print("Application must be defined");
            exit(1);
        }

        $this->bootstrap = new Bootstrap($loader);

        Error\Handler::register();
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function handle()
    {
        try {
            $application  = new PhalconApplication($this->bootstrap->getServices()->getDi());
            $moduleConfig = new Frontend\Config\Module\Module();
            $result       = [];

            if ($moduleConfig) {
                foreach ($moduleConfig->toArray()['module']['modules'] as $moduleName) {
                    $classPath           = HelperPath::arrayToNamespace([
                            HelperPath::arrayToNamespace($moduleConfig->toArray()['module']['settings']['namespace']),
                            \ucfirst($moduleName),
                            $moduleConfig->toArray()['module']['settings']['className'],
                        ]
                    );
                    $result[$moduleName] = [
                        "className" => $classPath,
                    ];
                }
            }

            $application->registerModules($result);

            return $application->handle()->getContent();
        } catch (\Exception $e) {
            echo $e->getMessage();

            exit;
        }
    }
}
