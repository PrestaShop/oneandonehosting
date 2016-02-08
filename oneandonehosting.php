<?php
/**
* 2007-2015 PrestaShop
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
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_'))
	exit;

class OneAndOneHosting extends Module
{
	protected $config_form = false;

	public function __construct()
	{
		$this->name = 'oneandonehosting';
		$this->tab = 'others';
		$this->version = '1.0.2';
		$this->author = 'PrestaShop';

		$this->bootstrap = true;

		parent::__construct();

		$this->displayName = $this->l('1and1 Hosting');
		$this->description = $this->l('PrestaShop Installed & hosted in minutes.');

		if (_PS_VERSION_ < '1.5')
			require(_PS_MODULE_DIR_.$this->name.'/backward_compatibility/backward.php');
	}

	public function install()
	{
		return parent::install() && $this->registerHook('backOfficeHeader');
	}

	public function hookBackOfficeHeader()
	{
		if (strcmp(Tools::getValue('configure'), $this->name) === 0)
		{
			if (version_compare(_PS_VERSION_, '1.5', '>') == true)
			{
				$this->context->controller->addCSS($this->_path.'views/css/configure.css');

				if (version_compare(_PS_VERSION_, '1.6', '<') == true)
					$this->context->controller->addCSS($this->_path.'views/css/configure-nobootstrap.css');
			}
			else
			{
				$html = '<link rel="stylesheet" href="'.$this->_path.'views/css/configure.css" type="text/css" />';
				$html .= '<link rel="stylesheet" href="'.$this->_path.'views/css/configure-nobootstrap.css" type="text/css" />';

				return $html;
			}
		}
	}

	public function getContent()
	{
		switch (Tools::strtolower($this->context->country->iso_code))
		{			
			case 'ca':
				$landing_page = 'https://www.awin1.com/awclick.php?mid=4876&id=253683';
				break;
			case 'uk':
				$landing_page = 'http://being.successfultogether.co.uk/click.asp?ref=657157&site=3759&type=text&tnb=32&diurl=https://www.1and1.co.uk/hosting';
				break;
			case 'fr':
				$landing_page = 'http://clic.reussissonsensemble.fr/click.asp?ref=701368&site=4320&type=text&tnb=125';
				break;
			case 'es':
				$landing_page = 'http://web.epartner.es/click.asp?ref=676625&site=5327&type=text&tnb=20';
				break;
			case 'mx':
				$landing_page = 'https://www.awin1.com/awclick.php?mid=5520&id=253683';
				break;
			case 'de':
			case 'at':
				$landing_page = 'http://hosting.1und1.de/webhosting-prestashop?ac=OM.PU.PUi80K244477T7073a&ref=657154';
				break;
			case 'it':
				$landing_page = 'https://clk.tradedoubler.com/click?p=219515&a=2308094&g=21125858';
				break;
			case 'pl':
				$landing_page = 'http://clk.tradedoubler.com/click?p=199398&a=2437674&g=19589768';
				break;
			case 'nl':
				$landing_page = 'http://www.tkqlhce.com/click-7873503-10384882-1380319321000';
				break;
			default:
				$landing_page = 'http://www.tkqlhce.com/click-7873503-10384882-1380319321000';
		}
		$this->context->smarty->assign(array(
			'module_dir' => $this->_path,
			'landing_page' => $landing_page,
		));

		return $this->display(__FILE__, 'views/templates/admin/configure.tpl');
	}
}
