<?php

declare(strict_types=1);

namespace Tests\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\CodeRhapsodie\SyliusExtendedElasticsearchPlugin\Behat\Page\Shop\HomePageInterface;

class HomepageContext implements Context
{
    /**
     * @var HomePageInterface
     */
    private $homePage;

    public function __construct(HomePageInterface $homePage)
    {
        $this->homePage = $homePage;
    }

    /**
     * @When /^I open the home page$/
     */
    public function iOpenTheHomePage()
    {
        $this->homePage->open();
    }
}
