<?php


if (!defined('_PS_VERSION_'))
    exit;

class sestylejs extends Module
{
    /**
     * @var AdminSeStyleJsTab
     */
    protected $tabObject;
    public $name;
    public $tab;
    public $tabClassName;
    public $displayName;
    public $description;


    public function __construct()
    {
        $this->name = 'sestylejs';
        $this->tab = 'Design';
        $this->tabClassName = 'AdminSeStyleJsTab';
        $this->version = 1.0;
        $this->author = 'Stéphane Erard';
        $this->need_instance = 0;

        parent::__construct();

        $this->displayName = $this->l('Style & Js');
        $this->description = $this->l('Lets you add stylesheets & javascripts');
    }

    public function createTabObject(){
        require __DIR__ . '/AdminSeStyleJsTab.php';
        $this->tabObject = new AdminSeStyleJsTab($this);
    }

    public function install()
    {
        $this->createTabObject();

        return
                parent::install()
                && $this->registerHook('header')
                && $this->registerHook('footer')
                && $this->tabObject->install();
    }

    public function uninstall() {
        $this->createTabObject();

        return parent::uninstall()
            && $this->unregisterHook('header')
            && $this->unregisterHook('footer')
            && $this->tabObject->uninstall();
    }

    public function getStylesKey()
    {
        return $this->name . '_styles';
    }

    public function getJavascriptsKey()
    {
        return $this->name . '_javascripts';
    }

    public function getContent()
    {
        if (Tools::isSubmit('sestylejs')) {
            Configuration::updateValue($this->getStylesKey(), Tools::getValue($this->getStylesKey()));
            Configuration::updateValue($this->getJavascriptsKey(), Tools::getValue($this->getJavascriptsKey()));
        }
        return $this->generateContent();
    }

    protected function generateContent()
    {
        $smarty = $this->context->getContext()->smarty;
        $smarty->assign('form', $this->generateForm());
        $smarty->assign('root_url', 'http://' . ShopUrl::getMainShopDomain());
        $smarty->assign('trans', array(
            $this->getStylesKey() => 'Style',
            $this->getJavascriptsKey() => 'Javascript',
        ));
        $content = $smarty->fetch(__DIR__ . '/templates/admin.tpl', null, null, null, false);

        return $content;
    }

    protected function generateForm()
    {
        $form = array(
            array(
                'id' => $this->getStylesKey(),
                'value' => Configuration::get($this->getStylesKey()),
                'language' => 'css',
            ),
            array(
                'id' => $this->getJavascriptsKey(),
                'value' => Configuration::get($this->getJavascriptsKey()),
                'language' => 'js',
            )
        );

        return $form;
    }

    public function hookHeader()
    {
        return '<style>' . Configuration::get($this->getStylesKey()) . '</style>';
    }

    public function hookFooter()
    {
        return '<script type="text/javascript">' . Configuration::get($this->getJavascriptsKey()) . '</script>';
    }
}