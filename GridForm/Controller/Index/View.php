<?php
/**
 * @package    TrainingMonish_GridForm
 * @author     monish.trivedi@krishtechnolabs.com
 */

namespace TrainingMonish\GridForm\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Exception\NotFoundException;
use TrainingMonish\GridForm\Block\GridFormView;

class View extends \Magento\Framework\App\Action\Action
{
	protected $_gridformview;

	public function __construct(
        Context $context,
        GridFormView $gridformview
    ) {
        $this->_gridformview = $gridformview;
        parent::__construct($context);
    }

	public function execute()
    {
    	if(!$this->_gridformview->getSingleData()){
    		throw new NotFoundException(__('Parameter is incorrect.'));
    	}
    	
        $this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
