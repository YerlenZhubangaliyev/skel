<?php
namespace App\Vendor\Phalcon\Error;

use Phalcon\Di;
use Monolog\Logger;

/**
 *
 */
class Handler
{

    /**
     * Registers itself as error and exception handler.
     *
     * @return void
     */
    public static function register()
    {
        switch (ENVIRONMENT) {
            case \App::ENV_PRODUCTION:
            case \App::ENV_STAGING:
            default:
                ini_set('display_errors', 0);
                error_reporting(0);
                break;
            case \App::ENV_LOCAL:
            case \App::ENV_TEST:
            case \App::ENV_DEVELOPMENT:
                ini_set('display_errors', 1);
                error_reporting(-1);
                break;
        }

        set_error_handler(function ($errno, $errstr, $errfile, $errline) {
            if (!($errno & error_reporting())) {
                return;
            }
            $options = [
                'type'    => $errno,
                'message' => $errstr,
                'file'    => $errfile,
                'line'    => $errline,
                'isError' => true,
            ];
            static::handle(new Error($options));
        });

        set_exception_handler(function (\Exception $e) {
            $options = [
                'type'        => $e->getCode(),
                'message'     => $e->getMessage(),
                'file'        => $e->getFile(),
                'line'        => $e->getLine(),
                'isException' => true,
                'exception'   => $e,
            ];
            static::handle(new Error($options));
        });

        register_shutdown_function(function () {
            if (!is_null($options = error_get_last())) {
                static::handle(new Error($options));
            }
        });
    }

    /**
     * Logs the error and dispatches an error controller.
     *
     * @param \App\Vendor\Phalcon\Error\Error $error
     *
     * @return mixed
     */
    public static function handle(Error $error)
    {
        $di      = Di::getDefault();
        $config  = $di->getConfig()->error->toArray();
        $logger  = $di->getLogger();
        $type    = static::getErrorType($error->type());
        $message = "$type: {$error->message()} in {$error->file()} on line {$error->line()}";

        $logger->log(static::getLogType($error->type()), $message);

        switch ($error->type()) {
            case E_WARNING:
            case E_NOTICE:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
            case E_USER_NOTICE:
            case E_STRICT:
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
            case E_ALL:
                break;
            case 0:
            case E_ERROR:
            case E_PARSE:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_RECOVERABLE_ERROR:
                if ($di->has('view')) {
                    $dispatcher = $di->getDispatcher();
                    $view       = $di->getView();
                    $response   = $di->getResponse();

                    $dispatcher->setControllerName($config['controller']);
                    $dispatcher->setActionName($config['action']);
                    $dispatcher->setParams(['error' => $error]);
                    $view->start();
                    $dispatcher->dispatch();
                    $view->render($config['controller'], $config['action'], $dispatcher->getParams());
                    $view->finish();

                    return $response->setContent($view->getContent())->send();
                } else {
                    echo $message;
                }
        }
    }

    /**
     * Maps error code to a string.
     *
     * @param  integer $code
     *
     * @return string
     */
    public static function getErrorType($code)
    {
        switch ($code) {
            case 0:
                return 'Uncaught exception';
            case E_ERROR:
                return 'E_ERROR';
            case E_WARNING:
                return 'E_WARNING';
            case E_PARSE:
                return 'E_PARSE';
            case E_NOTICE:
                return 'E_NOTICE';
            case E_CORE_ERROR:
                return 'E_CORE_ERROR';
            case E_CORE_WARNING:
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR:
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING:
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR:
                return 'E_USER_ERROR';
            case E_USER_WARNING:
                return 'E_USER_WARNING';
            case E_USER_NOTICE:
                return 'E_USER_NOTICE';
            case E_STRICT:
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR:
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED:
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED:
                return 'E_USER_DEPRECATED';
        }

        return $code;
    }

    /**
     * Maps error code to a log type.
     *
     * @param  integer $code
     *
     * @return integer
     */
    public static function getLogType($code)
    {
        switch ($code) {
            case E_ERROR:
            case E_RECOVERABLE_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_PARSE:
                return Logger::ERROR;
            case E_WARNING:
            case E_USER_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
                return Logger::WARNING;
            case E_NOTICE:
            case E_USER_NOTICE:
                return Logger::NOTICE;
            case E_STRICT:
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                return Logger::INFO;
        }

        return Logger::ERROR;
    }
}
