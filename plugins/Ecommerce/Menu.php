<?php
/**
 * Piwik - free/libre analytics platform
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 */
namespace Piwik\Plugins\Ecommerce;

use Piwik\Common;
use Piwik\Menu\MenuReporting;
use Piwik\Menu\MenuUser;
use Piwik\Piwik;
use Piwik\Site;
use Piwik\Translate;

/**
 */
class Menu extends \Piwik\Plugin\Menu
{

    public function configureReportingMenu(MenuReporting $menu)
    {
        $idSite = Common::getRequestVar('idSite', null, 'int');

        $site = new Site($idSite);

        if ($site->isEcommerceEnabled()) {
            $ecommerceParams = array('idGoal' => Piwik::LABEL_ID_GOAL_IS_ECOMMERCE_ORDER);
            $ecommerceUrl    = $this->urlForAction('ecommerceReport', $ecommerceParams);

            $menu->addItem('Goals_Ecommerce', '', $ecommerceUrl, 24);
            $menu->addItem('Goals_Ecommerce', 'Goals_EcommerceOverview', $ecommerceUrl, 1);
            $menu->addItem('Goals_Ecommerce', 'Goals_EcommerceLog', $this->urlForAction('getEcommerceLog'), 2);
            $menu->addItem('Goals_Ecommerce', 'Goals_Products', $this->urlForAction('ecommerceProducts', $ecommerceParams), 3);
        }

    }
    public function configureUserMenu(MenuUser $menu)
    {
        $idSite = Common::getRequestVar('idSite', null, 'int');

        if (Piwik::isUserHasAdminAccess($idSite)) {
            $menu->addManageItem('Goals_GoalsManagement', $this->urlForAction('manage'), 15);
        }
    }
}
