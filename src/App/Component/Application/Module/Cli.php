<?php
namespace App\Component\Application\Module;

use App\Traits\DependencyInjection;
use App\Helper\Path as HelperPath;
use Phalcon\Di;
use Phalcon\DiInterface;
use Phalcon\Cli\Dispatcher as CliDispatcher;
use Phalcon\Cli\Router as CliRouter;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Text;

/**
 * {@inheritdoc}
 */
class Cli implements ModuleDefinitionInterface
{

    use DependencyInjection;

    /**
     * @param \Phalcon\DiInterface|null $dependencyInjector
     */
    public function registerAutoloaders(DiInterface $dependencyInjector = null)
    {

    }

    /**
     * @param \Phalcon\DiInterface|null $dependencyInjector
     */
    public function registerServices(DiInterface $dependencyInjector = null)
    {
        $di = Di::getDefault();

        $di->set('router', function(){
            $router = new CliRouter();

            return $router;
        });

        $di->set('dispatcher', function () use($di) {
            $eventsManager = $di->getShared('eventsManager');

            $eventsManager->attach("dispatch:beforeDispatchLoop", function($event, $dispatcher) {
                $dispatcher->setActionName(Text::camelize($dispatcher->getActionName()));
            });

            $dispatcher = new CliDispatcher();
            $dispatcher->setEventsManager($eventsManager);
            $dispatcher->setDefaultNamespace(HelperPath::arrayToNamespace([
                "App",
                "Applications",
                "Cli",
                "Modules",
                \ucfirst($di->getShared('router')->getModuleName()),
                "Task",
            ], false));

            return $dispatcher;
        });

        $this->setDi($di);
    }
}
