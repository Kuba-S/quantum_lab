<?php
declare(strict_types=1);

namespace QL\Domain\Person\ReadModel;

class FindPersonHandler
{
    public function findByStringAction(FindPersonByStringQuery $findPersonByStringQuery): string
    {
        return $findPersonByStringQuery->getSearchString();
    }
}
