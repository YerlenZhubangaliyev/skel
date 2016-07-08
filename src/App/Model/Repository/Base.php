<?php
namespace App\Model\Repository;

use App\Abstractions\Repository;

/**
 * Base repository
 */
class Base extends Repository
{

    /**
     * @param $id
     *
     * @return boolean|static
     * @throws \Exception
     */
    public function getOneById($id)
    {
        $entity = $this->getEntity()->findFirst($id);

        if ($entity) {
            return $entity;
        }

        return false;
    }
}
