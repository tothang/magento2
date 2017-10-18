<?php
/**
 *
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Thang\Banner\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Thang\Banner\Model\Banner;
use Magento\Framework\App\Request\DataPersistorInterface;


class Save extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Thang_Banner::save';

    /**
     * @var PostDataProcessor
     */
    protected $dataProcessor;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var \Magento\Cms\Model\PageFactory
     */
    private $pageFactory;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @param Action\Context $context
     * @param PostDataProcessor $dataProcessor
     * @param DataPersistorInterface $dataPersistor
     * @param \Magento\Cms\Model\PageFactory $pageFactory
     * @param \Magento\Cms\Api\PageRepositoryInterface $pageRepository
     *
     */
    public function __construct(
        Action\Context $context,
        PostDataProcessor $dataProcessor,
        DataPersistorInterface $dataPersistor

    ) {
        $this->dataProcessor = $dataProcessor;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            if (isset($data['status']) && $data['status'] === 'true') {
                $data['status'] = Banner::STATUS_ENABLED;
            }
            if (empty($data['id'])) {
                $data['id'] = null;
            }

            /** @var \Magento\Cms\Model\Page $model */
            // Init model and load by ID if exists
            $model = $this->_objectManager->create('Thang\Banner\Model\Banner');
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $model->load($id);
            }
           $data['image']=$data['images'][0]['name'];




            if (!$this->dataProcessor->validateRequireEntry($data)) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
            }
            $model->setData($data);
            try {
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the banner.'));
                $this->dataPersistor->clear('banner');
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addExceptionMessage($e->getPrevious() ?:$e);
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the image.'));
            }

            $this->dataPersistor->set('banner', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
        }
        // Redirect to List page
        return $resultRedirect->setPath('*/*/');
    }
}
