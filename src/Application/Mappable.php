<?php
declare(strict_types=1);

namespace QL\Application;

interface Mappable
{
    public static function fromCliParams(array $params);
}
