<?php

/*
 * This file has been created by developers from BitBag.
 * Feel free to contact us once you face any issues or want to start
 * another great project.
 * You can find more information about us on https://bitbag.shop and write us
 * an email on mikolaj.krol@bitbag.pl.
 */

declare(strict_types=1);

namespace CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Controller\RequestDataHandler;

interface SortDataHandlerInterface extends DataHandlerInterface
{
    public const ORDER_BY_INDEX = 'order_by';

    public const SORT_INDEX = 'sort';

    public const SORT_ASC_INDEX = 'asc';

    public const SORT_DESC_INDEX = 'desc';
}
