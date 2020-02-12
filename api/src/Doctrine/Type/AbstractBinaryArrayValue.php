<?php

namespace App\Doctrine\Type;

use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

abstract class AbstractBinaryArrayValue extends Type
{
    const BINARY_ARRAY = 'binary_array';

    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return $platform->getIntegerTypeDeclarationSQL($fieldDeclaration);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $value = $value >= 1 ? $value : '1';

        $value = hexdec((string)$value);
        $mapping = $this->getMapping();
        $bitArray = array_reverse(str_split(decbin($value)));
        $bitArray = array_pad($bitArray, count($mapping), '0');
        for ($i = 0; $i < count($mapping); $i++) {
            $bitArray[$i] == '1' ? $bitArray[$i] = true : $bitArray[$i] = false;
        }

        $r1 = array_combine($this->getMapping(), $bitArray);
        $r2 = array_keys($r1, true);
        return $r2;
    }

    public function convertToDatabaseValue($values, AbstractPlatform $platform)
    {
        if (empty($values)) {
            return 1;
        }
        $binany_roles = 1;
        $mapping = $this->getMapping();
        foreach ($mapping as $index => $value) {
            if (array_search($value, $values)) {
                $binany_roles += pow(2, $index);
            }
        }
        $hex_roles = dechex($binany_roles);
        return ($hex_roles);
    }

    public function getName()
    {
        return self::BINARY_ARRAY;
    }

    /**
     * @return array
     */
    abstract protected function getMapping();

    /**
     * @param AbstractPlatform $platform
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }
}
