<?php
namespace App\Applications\Frontend\Modules\Admin\Controller;

use App\Controller;
use App\Traits\Translate;

/**
 * Базовый контролле
 */
class BaseController extends Controller
{

    use Translate;

    /**
     * {@inheritdoc}
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
        parent::beforeExecuteRoute($dispatcher);
    }
}
