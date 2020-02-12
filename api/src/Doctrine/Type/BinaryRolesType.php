<?php


namespace App\Doctrine\Type;

class BinaryRolesType extends AbstractBinaryArrayValue
{
    const BINARY_ROLES = 'binary_roles';

    public function getName()
    {
        return self::BINARY_ROLES;
    }

    /**
     * @return mixed
     */
    protected function getMapping()
    {
        return [
            'ROLE_USER',
            'ROLE_ADMIN'
        ];
    }
}
