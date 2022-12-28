<?php

namespace Ns3777k\DoctrineDbalYoutube\DBAL\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Platforms\PostgreSQLPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\Type;
use Ns3777k\DoctrineDbalYoutube\VO\IpBlock;
use RuntimeException;

class SuperInetType extends Type
{
    public function getSQLDeclaration(array $column, AbstractPlatform $platform)
    {
        if ($platform instanceof PostgreSQLPlatform) {
            return Types::PG_SUPER_INET->value;
        }

        throw new RuntimeException(sprintf(
            'Type %s is not supported by platform %s', $this->getName(), $platform::class));
    }

    public function getName()
    {
        return Types::SUPER_INET->value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if ($value instanceof IpBlock) {
            return $value->toHumanReadable();
        }

        throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', IpBlock::class]);
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new IpBlock($value);
    }
}
