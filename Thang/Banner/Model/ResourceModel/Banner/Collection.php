<?php

namespace Thang\Banner\Model\ResourceModel\Banner;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    protected $_idFieldName = 'id';

    protected function _construct()
    {
        // Model + Resource Model
        $this->_init('Thang\Banner\Model\Banner', 'Thang\Banner\Model\ResourceModel\Banner');
    }

}