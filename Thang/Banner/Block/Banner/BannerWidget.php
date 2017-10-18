<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Thang\Banner\Block\Banner;

use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Thang\Banner\Model\ResourceModel\Banner\CollectionFactory;

/**
 * Catalog Products List widget block
 * Class ProductsList
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class BannerWidget extends Template implements BlockInterface
{

    protected $rule;

    /**
     * @var \Magento\Widget\Helper\Conditions
     */
    protected $conditionsHelper;


    public function __construct(
        Template\Context $context,
        \Thang\Banner\Model\ResourceModel\Banner\CollectionFactory $bannerCollectionFactory,

        array $data = [],
        Json $json = null
    ) {
        $this->setTemplate('widget.phtml');
        $this->bannerCollectionFactory = $bannerCollectionFactory;
        parent::__construct(
            $context,
            $data
        );
    }


    protected function _beforeToHtml()
    {
        $collection = $this->bannerCollectionFactory->create();

        $banners = $collection->addFieldToFilter('status', ['eq' => true])->getData();
        $this->setData('banners', $banners);
        $this->setData('mediaURL', $this->_storeManager->getStore()
                ->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . 'banner/tmp/images/');
        return parent::_beforeToHtml();
    }


}
