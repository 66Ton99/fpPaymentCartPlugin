# fpPaymentCartPlugin

It depends on fpPaymentPlugin, sfJqueryReloadedPlugin

_ProjectConfiguration.class.php_

    public function setup()
    {
      $this->enablePlugins('sfDoctrinePlugin');
      $this->enablePlugins('sfDoctrineGuardPlugin');
      $this->enablePlugins('sfJqueryReloadedPlugin');
      $this->enablePlugins('fpPaymentPlugin');
      $this->enablePlugins('fpPaymentCartPlugin');
    }


You have to enable "fpPaymentCart"

_settings.yml_

    all:
      .settings:
        enabled_modules:
          - fpPaymentCart
    

Get the plugin's resources by typing:

    ./symfony plugin:publish-assets
    

Then clear the cache:

    ./symfony cc
    

You have to create fp_payment_cart.yml file in to yours config folder and configure it.

_fp_payment_cart.yml_

    all:
      object_classes_names: 'product table' # put there the name your product table
     

## How to use

You have to include the buttons in the view. You can add the component by adding those lines:

    include_component('fpPaymentCart',
                      'editbox',
                      array('object_class_name' => strtolower($productModel->getTable()->getTableName()),
                            'object_id' => $productModel->getId(),
                            'actions' => array('new')))
    