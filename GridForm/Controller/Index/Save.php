<?php
/**
 * @package    TrainingMonish_GridForm
 * @author     monish.trivedi@krishtechnolabs.com
 */

namespace TrainingMonish\GridForm\Controller\Index;

use Magento\Framework\App\Action\Context;
use TrainingMonish\GridForm\Model\GridFormFactory;

class Save extends \Magento\Framework\App\Action\Action
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
	public function execute()
    {
        //$data = $this->getRequest()->getParams();        
        $data['title'] = $_POST['title'];
        $data['author'] = $_POST['author'];
        $data['content'] = $_POST['content'];
        $data['preferred_language'] = implode(",", $_POST['preferred_language']);
        $data['content'] = $_POST['content'];
        $data['country'] = $_POST['country'];
        $data['newsletter'] = $_POST['newsletter'];
        $data['favcolor'] = $_POST['favcolor'];
        $data['location'] = implode(",", $_POST['location']);        
       
    	$gridform = $this->_gridform->create();
        $gridform->setData($data);
        if($gridform->save()){
            $this->messageManager->addSuccessMessage(__('You saved the data.'));
        }else{
            $this->messageManager->addErrorMessage(__('Data was not saved.'));
        }
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('gridform/index/index');
        return $resultRedirect;
    }
}
