<?php
namespace App\Applications;

use App\Application as BaseApplication;
use App\Bootstrap;
use App\Helper\Cli\Options;
use App\Helper\Path as HelperPath;
use Composer\Autoload\ClassLoader;
use Phalcon\Cli\Console;
use Phalcon\Di;

/**
 * Cli initialization
 */
class Cli extends BaseApplication
{

    /**
     * {@inheritdoc}
     *
     * @param \Composer\Autoload\ClassLoader $loader
     */
    public function __construct(ClassLoader $loader)
    {
        $this->loader = $loader;

        if (!defined('ENVIRONMENT')) {
            print("Environment must be defined");
            exit(1);
        }

        if (!defined('APPLICATION')) {
            print("Application must be defined");
            exit(1);
        }

        $this->bootstrap = new Bootstrap($loader);
    }

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        try {
            $application  = new Console($this->bootstrap->getServices()->getDi());
            $moduleConfig = new Cli\Config\Module\Module();
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

            $application->handle(Options::getOptions());
        } catch (\Exception $e) {
            echo sprintf(
                "%s, %s, %s",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine()
            );
            
            exit;
        }
    }
}
