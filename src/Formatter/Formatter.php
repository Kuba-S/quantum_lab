<?php
namespace QL\Formatter;

interface Formatter
{
    public function formatOne($object): string;

    public function formatMany(array $objectList): string;
}
