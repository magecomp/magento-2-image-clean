<?php
namespace Magecomp\Imageclean\Block;

use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Imageclean extends Template {
    /**
     * @var Registry
     */
    protected $_frameworkRegistry;

    public function __construct(Context $context, 
        Registry $frameworkRegistry, 
        array $data = [])
    {
        $this->_frameworkRegistry = $frameworkRegistry;

        parent::__construct($context, $data);
    }


    public function _prepareLayout() {
        return parent::_prepareLayout();
    }

    public function getImageclean() {
        if (!$this->hasData('imageclean')) {
            $this->setData('imageclean', $this->_frameworkRegistry->registry('imageclean'));
        }
        return $this->getData('imageclean');
    }

}
