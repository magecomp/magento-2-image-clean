<?php
namespace Magecomp\Imageclean\Model;

use Magento\Framework\DataObject;

class Status extends DataObject {

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 2;

    static public function getOptionArray() {
        return [
            self::STATUS_ENABLED => __('Enabled'),
            self::STATUS_DISABLED => __('Disabled')
        ];
    }

}
