<?php
/**
 * @package    TrainingMonish_GridForm
 * @author     monish.trivedi@krishtechnolabs.com
 */

namespace TrainingMonish\GridForm\Block;

use Magento\Framework\View\Element\Template\Context;
use TrainingMonish\GridForm\Model\GridFormFactory;
/**
 * GridForm List block
 */
class GridFormListData extends \Magento\Framework\View\Element\Template
{
    /**
     * @var GridForm
     */
    protected $_gridform;
    public function __construct(
        Context $context,
        GridFormFactory $gridform
    ) {
        $this->_gridform = $gridform;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Online Book Register List Page'));
        
        if ($this->getGridFormCollection()) {
            $pager = $this->getLayout()->createBlock(
                'Magento\Theme\Block\Html\Pager',
                'trainingmonish.gridform.pager'
            )->setAvailableLimit(array(5=>5,10=>10,15=>15))->setShowPerPage(true)->setCollection(
                $this->getGridFormCollection()
            );
            $this->setChild('pager', $pager);
            $this->getGridFormCollection()->load();
        }
        return parent::_prepareLayout();
    }

    public function getGridFormCollection()
    {
        $page = ($this->getRequest()->getParam('p'))? $this->getRequest()->getParam('p') : 1;
        $pageSize = ($this->getRequest()->getParam('limit'))? $this->getRequest()->getParam('limit') : 5;

        $gridform = $this->_gridform->create();
        $collection = $gridform->getCollection();
        $collection->addFieldToFilter('status','1');
        //$gridform->setOrder('gridform_id','ASC');
        $collection->setPageSize($pageSize);
        $collection->setCurPage($page);

        return $collection;
    }

    public function getPagerHtml()
    {
        return $this->getChildHtml('pager');
    }
}