<?php
namespace App\Component\Application\Module;

use App\View\Functions;
use App\Helper\Path as HelperPath;
use Phalcon\Di;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\ModuleDefinitionInterface;
use Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use Phalcon\Events\Manager as EventsManager;

/**
 * {@inheritdoc}
 */
class Frontend implements ModuleDefinitionInterface
{

    /**
     * Register a specific autoLoader for the module
     */
    public function registerAutoloaders(DiInterface $dependencyInjector = null)
    {

    }

    /**
     * @param \Phalcon\DiInterface|null $dependencyInjector
     */
    public function registerServices(DiInterface $dependencyInjector = null)
    {
        $dependencyInjector = Di::getDefault();

        $dependencyInjector->set('view', function () use ($dependencyInjector) {
            $view                  = new View();
            $viewDirectory         = HelperPath::arrayToPath([
                ROOT_DIR,
                "src",
                "App",
                "Applications",
                "Frontend",
                "View",
                \ucfirst($dependencyInjector->getShared('router')->getModuleName()),
            ], true, false);
            $viewCompiledDirectory = HelperPath::arrayToPath(
                [
                    ROOT_DIR,
                    "cache",
                    "view",
                ],
                true,
                false
            );

            $view->setViewsDir($viewDirectory);
            $view->registerEngines(
                [
                    '.volt' => function ($view, $dependencyInjector) use ($viewCompiledDirectory) {
                        $volt = new VoltEngine($view, $dependencyInjector);
                        $volt->setOptions([
                            'compiledPath'  => $viewCompiledDirectory,
                            'stat'          => true,
                            'compileAlways' => true,
                        ]);

                        new Functions($volt);

                        return $volt;
                    },
                ]
            );

            return $view;
        });

        $dependencyInjector->set('dispatcher', function () use ($dependencyInjector) {
            $dispatcher    = new Dispatcher();
            $eventsManager = new EventsManager();

            $eventsManager->attach("dispatch", function ($event, $dispatcher, $exception) {
                if ($event->getType() == 'beforeException') {
                    switch ($exception->getCode()) {
                        case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                        case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        case Dispatcher::EXCEPTION_INVALID_PARAMS:
                            $dispatcher->forward([
                                'controller' => 'error',
                                'action'     => 'index'
                            ]);

                            return false;
                    }
                }
            });

            $dispatcher->setDefaultNamespace(HelperPath::arrayToNamespace([
                "App",
                "Applications",
                "Frontend",
                "Modules",
                \ucfirst($dependencyInjector->getShared('router')->getModuleName()),
                "Controller",
            ], false));

            $dispatcher->setEventsManager($eventsManager);

            return $dispatcher;
        });
    }
}
