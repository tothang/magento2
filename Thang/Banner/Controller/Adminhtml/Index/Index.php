<?php

namespace Thang\Banner\Controller\Adminhtml\Index;

class Index extends \Magento\Backend\App\Action
{

    const ADMIN_RESOURCE = 'Thang_Banner::banner_manager';
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory\
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // Load layout and set active menu
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Thang_Banner::banner_manager');
        $resultPage->getConfig()->getTitle()->prepend(__('Banner manager'));

        return $resultPage;
    }

}