<?php
declare(strict_types=1);

namespace QL\Command;

interface Mappable
{
    public static function fromCliParams(array $params);
}
