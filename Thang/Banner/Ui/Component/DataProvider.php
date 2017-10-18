<?php

namespace Thang\Banner\Ui\Component;

use Thang\Banner\Model\ResourceModel\Banner\Collection;

class DataProvider  extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $collection;


    /**
     * @var array
     */
    protected $loadedData;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Collection $collection,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collection;

    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $item) {
            $data = $item->getData();

            $this->loadedData[$item->getId()] = $data;
        }

        return $this->loadedData;
    }
}