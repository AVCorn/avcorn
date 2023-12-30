<?php

/**
 * Acceptance Testing
 *
 * PHP version 8.2
 *
 * @category   CMS
 * @package    AVCorn
 * @subpackage Acceptance
 * @author     Benjamin J. Young <ben@blaher.me>
 * @license    GNU General Public License, version 3
 * @link       https://github.com/avcorn/avcorn
 */

namespace Tests\Acceptance;

use Tests\Support\AcceptanceTester;

/**
 * MainCest Class
 */
class MainCest
{
    /**
     * Test frontpage works
     *
     * @param AcceptanceTester $I Acceptance Tester
     *
     * @return void
     */
    public function frontpageWorks(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
    }
}
