<?php

/**
 * fpPaymentCartPlugin configuration
 *
 * @package    fpPayment
 * @subpackage Cart
 * @author 	   Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class fpPaymentCartPluginConfiguration extends sfPluginConfiguration
{
  
  /**
   * (non-PHPdoc)
   * @see sfPluginConfiguration::initialize()
   */
  public function initialize()
  {
    $configFiles = $this->configuration->getConfigPaths('config/fp_payment_cart.yml');
    $config = sfDefineEnvironmentConfigHandler::getConfiguration($configFiles);
    
    foreach ($config as $name => $value) {
      sfConfig::set("fp_payment_cart_{$name}", $value);  
    }
  }
  
}