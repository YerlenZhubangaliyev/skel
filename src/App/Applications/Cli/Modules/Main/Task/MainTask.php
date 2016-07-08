<?php
namespace App\Applications\Cli\Modules\Main\Task;

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
        Output::out('main');
    }
}
