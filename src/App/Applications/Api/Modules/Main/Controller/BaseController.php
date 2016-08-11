<?php
namespace App\Applications\Frontend\Modules\Main\Controller;

use App\Abstractions\Controller\Api as Controller;
use App\Traits\Translate;

/**
 * Base controller
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
