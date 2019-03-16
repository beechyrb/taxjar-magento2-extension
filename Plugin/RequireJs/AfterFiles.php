<?php
/**
 * Taxjar_SalesTax
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Taxjar
 * @package    Taxjar_SalesTax
 * @copyright  Copyright (c) 2017 TaxJar. TaxJar is a trademark of TPS Unlimited, Inc. (http://www.taxjar.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 */

namespace Taxjar\SalesTax\Plugin\RequireJs;

use Taxjar\SalesTax\Model\Configuration as TaxjarConfig;

class AfterFiles
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var \Magento\Framework\App\State
     */
    protected $state;

    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Framework\App\State $state
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->state = $state;
    }

    public function afterGetFiles(
        \Magento\Framework\RequireJs\Config\File\Collector\Aggregated $subject,
        $result
    ) {
        $isEnabled = $this->scopeConfig->getValue(TaxjarConfig::TAXJAR_ADDRESS_VALIDATION);

        // If address validation is disabled, remove frontend RequireJs dependencies
        if (!$isEnabled && $this->state->getAreaCode() == 'frontend') {
            foreach ($result as $key => &$file) {
                if ($file->getModule() == 'Taxjar_SalesTax') {
                    unset($result[$key]);
                }
            }
        }

        return $result;
    }
}
