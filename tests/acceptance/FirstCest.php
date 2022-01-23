<?php

class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function tryToTest(AcceptanceTester $I)
    {
    }

    public function frontpageWorks(AcceptanceTester $I)
    {

        $I->amOnPage('http://127.0.0.1:8000/api/current_server_time');
        $I->seeResponseCodeIs(200);

    }

}
