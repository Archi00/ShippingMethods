<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

class Displayshippingmethods extends Module
{
    public function __construct()
    {
        $this->name = 'displayshippingmethods';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'Archi00';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

        /**
         * Set $this->bootstrap to true if your module is compliant with bootstrap (PrestaShop 1.6)
         */
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Display Shipping Methods');
        $this->description = $this->l('Module that let\'s you display the current shipping methods in the footer');
        if (!Configuration::get('DISPLAYSHIPPINGMETHODS_NAME')) {
            $this->warning = $this->l('No name provided');
        }
    }

    /**
     * Don't forget to create update methods if needed:
     * http://doc.prestashop.com/display/PS16/Enabling+the+Auto-Update
     */
    public function install()
    {
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayFooter')
            && Configuration::updateValue('DISPLAYSHIPPINGMETHODS_NAME', 'Display Shipping Methods');
    }

    public function uninstall()
    {
        return (
        parent::uninstall() &&
        Configuration::deleteByName('DISPLAYSHIPPINGMETHODS_NAME')
        );
        
    }

    public function isUsingNewTranslationSystem()
    {
        return true;
    }

    /**
     * Add the CSS & JavaScript files you want to be added on the FO.
     */
    public function hookHeader()
    {
        $this->context->controller->addJS($this->_path.'/views/js/front.js');
        $this->context->controller->addCSS($this->_path.'/views/css/front.css');
    }

    public function hookDisplayFooter()
    {
        $sql = 'SELECT a.* , b.* FROM `ps_carrier` a INNER JOIN `ps_carrier_lang` b ON a.id_carrier = b.id_carrier AND b.id_shop = 1 AND b.id_lang = 2 LEFT JOIN `ps_carrier_tax_rules_group_shop` ctrgs ON (a.`id_carrier` = ctrgs.`id_carrier` AND ctrgs.id_shop=1) WHERE 1 AND a.`deleted` = 0 ORDER BY a.`position` ASC LIMIT 0, 50';
        $shipping_methods_query = Db::getInstance()->ExecuteS($sql);
        array_pop($shipping_methods_query);
        $shipping_methods_query[0]["name"] = $shipping_methods_query[0]["delay"];
        $this->context->smarty->assign([
            'shipping_methods_title' => $this->trans('SHIPPING METHODS', [], 'Modules.Displayshippingmethods.Title'),
            'shipping_methods_list' => $shipping_methods_query,
        ]);

        return $this->display(__FILE__, 'displayshippingmethods.tpl');
    }
}
