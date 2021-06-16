<?php
/**
 * @package    TrainingMonish_GridForm
 * @author     monish.trivedi@krishtechnolabs.com
 */

namespace TrainingMonish\GridForm\Block;

use Magento\Framework\View\Element\Template\Context;
use TrainingMonish\GridForm\Model\GridFormFactory;
use Magento\Cms\Model\Template\FilterProvider;
/**
 * GridForm View block
 */
class GridFormView extends \Magento\Framework\View\Element\Template
{
    /**
     * @var GridForm
     */
    protected $_gridform;
    public function __construct(
        Context $context,
        GridFormFactory $gridform,
        FilterProvider $filterProvider
    ) {
        $this->_gridform = $gridform;
        $this->_filterProvider = $filterProvider;
        parent::__construct($context);
    }

    public function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set(__('Online Book Register View Page'));
        
        return parent::_prepareLayout();
    }

    public function getSingleData()
    {
        $id = $this->getRequest()->getParam('id');
        $gridform = $this->_gridform->create();
        $singleData = $gridform->load($id);
        if($singleData->getGridFormId() || $singleData['gridform_id'] && $singleData->getStatus() == 1){
            return $singleData;
        }else{
            return false;
        }
    }
}