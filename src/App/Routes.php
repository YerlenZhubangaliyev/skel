<?php
namespace App;

use App\Traits\DependencyInjection;
use App\Helper\Arrays as HelperArray;
use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group;

/**
 * Базовые роуты
 */
class Routes
{

    use DependencyInjection;

    /**
     * @var
     */
    protected static $modules;

    /**
     * Router instance
     *
     * @var \Phalcon\Mvc\Router
     */
    protected $router;

    /**
     * Default module name
     *
     * @var string
     */
    protected static $defaultModule = 'main';

    /**
     * Default controller name
     *
     * @var string
     */
    protected static $defaultController = 'index';

    /**
     * Default action name
     *
     * @var string
     */
    protected static $defaultAction = 'index';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->router = new Router(true);

        $this->applyRoutes();

    }

    /**
     * Get router instance
     *
     * @return \Phalcon\Mvc\Router
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * Apply routes
     */
    public function applyRoutes()
    {
        $baseDomain = Di::getDefault()->getConfig()->application->domain;

        $this->router->setDefaultModule(self::$defaultModule);
        $this->router->setDefaultController(self::$defaultController);
        $this->router->setDefaultAction(self::$defaultAction);
        $this->router->removeExtraSlashes(true);

        if (count(self::$modules) > 0) {
            foreach (self::$modules as $moduleName => $moduleObject) {
                $routerGroupOptions = [
                    'module' => $moduleName,
                ];

                if (\array_key_exists('controller', $moduleObject)) {
                    $routerGroupOptions['controller'] = $moduleObject['controller'];
                }

                $routerGroup = new Group($routerGroupOptions);

                if ($moduleObject['rules']) {
                    $routerGroup->setPrefix($moduleObject['prefix']);

                    if (\array_key_exists('host', $moduleObject)) {
                        $routerGroup->setHostName($moduleObject['host'] . $baseDomain);
                    }

                    foreach ($moduleObject['rules'] as $ruleObject) {
                        $routeParams      = [];
                        $methodNamePrefix = 'add';

                        if (\array_key_exists('action', $ruleObject)) {
                            $routeParams['action'] = $ruleObject['action'];
                        } else {
                            $routeParams['action'] = self::$defaultAction;
                        }

                        if (\array_key_exists('controller', $ruleObject)) {
                            $routeParams['controller'] = \ucfirst($ruleObject['controller']);
                        }

                        if (\array_key_exists('params', $ruleObject)) {
                            $routeParams['params'] = $ruleObject['params'];
                        }

                        /** @var \Phalcon\Mvc\Router\Group $router */
                        $router     = null;
                        $methodName = $methodNamePrefix;

                        if (\is_array($ruleObject['method'])) {
                            $router = $routerGroup
                                ->$methodName($ruleObject['rule'], $routeParams)
                                ->via(HelperArray::arrayValuesToUpper($ruleObject['method']))
                            ;
                        } elseif (\strlen($ruleObject['method']) > 0) {
                            $methodName = $methodNamePrefix . \ucfirst($ruleObject['method']);
                            $router     = $routerGroup->$methodName($ruleObject['rule'], $routeParams);
                        }

                        if (\array_key_exists('name', $ruleObject)) {
                            $router->setName($ruleObject['name']);
                        }
                    }
                }

                $this->router->mount($routerGroup);
            }
        }
    }
}
