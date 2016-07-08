<?php
namespace App;

use Phalcon\Mvc\Controller as BaseController;
use Phalcon\Mvc\Dispatcher;

/**
 * Базовый класс контроллера
 */
class Controller extends BaseController
{

    /**
     * Инициализация чего-либо
     */
    public function initialize()
    {

    }

    /**
     * {@inheritdoc}
     *
     * @param $dispatcher
     */
    public function beforeExecuteRoute($dispatcher)
    {
        Di::getDefault()->getRegistry()->locale      = str_replace('-', '_', $this->request->getBestLanguage());
        Di::getDefault()->getRegistry()->language    = substr($this->request->getBestLanguage(), 0, 2);
        Di::getDefault()->getRegistry()->application = strtolower(APPLICATION);
        Di::getDefault()->getRegistry()->module      = $dispatcher->getModuleName();

        $locale = $dispatcher->getParam('locale');

        if (isset($locale) && !empty($locale)) {
            Di::getDefault()->getRegistry()->locale              = $locale;
            Di::getDefault()->getRegistry()->languageFromRequest = substr($locale, 0, 2);
        }
    }

    /**
     * @param $dispatcher
     */
    public function afterExecuteRoute($dispatcher)
    {
        if (!$this->view->isDisabled()) {
            $this->view->language    = Di::getDefault()->getRegistry()->language;
            $this->view->locale      = Di::getDefault()->getRegistry()->locale;
            $this->view->application = Di::getDefault()->getRegistry()->application;
            $this->view->module      = Di::getDefault()->getRegistry()->module;
        }

        $actionName = $dispatcher->getActionName();

        if (0 === strcasecmp(substr($actionName, 0, 4), 'ajax')) {
            $this->view->disable();
            $this->response
                ->setContentType('application/json')
                ->setContent(\json_encode((array)$dispatcher->getReturnedValue()))
                ->send()
            ;
        }
    }

    /**
     * Display errors
     */
    public function errorAction()
    {
        /** @var \Phalcon\Error\Error $error */
        $error = $this->dispatcher->getParam('error');
        $code  = 500;

        if ($error) {
            switch ($error->type()) {
                case 404:
                    $code = 404;
                    break;
                case 403:
                    $code = 403;
                    break;
                case 401:
                    $code = 401;
                    break;
            }
        }

        $this->response->resetHeaders()->setStatusCode($code, null);

        $this->view->setVars([
            'error'        => $error,
            'code'         => $code,
            'displayError' => (ENVIRONMENT != \App::ENV_PRODUCTION || ENVIRONMENT != \App::ENV_STAGING)
        ]);
    }
}
