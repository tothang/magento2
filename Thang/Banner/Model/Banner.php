<?php

namespace Thang\Banner\Model;

class Banner extends \Magento\Framework\Model\AbstractModel
{
    const STATUS_ENABLED = 1 ;
    const STATUS_DISABLED = 0 ;
    protected function _construct()
    {
        $this->_init('Thang\Banner\Model\ResourceModel\Banner');
    }

}