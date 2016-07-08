<?php
namespace App\Applications\Cli\Modules\Admin\Task;

use App\Helper\Cli\Output;

/**
 * Таск "по-умолчанию"
 */
class MainTask extends Base
{

    /**
     * {@inheritdoc}
     */
    public function mainAction()
    {
        Output::out('main admin');
    }
}
