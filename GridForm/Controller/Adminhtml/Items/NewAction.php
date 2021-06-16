<?php
/**
 * @package    TrainingMonish_GridForm
 * @author     monish.trivedi@krishtechnolabs.com
 */

namespace TrainingMonish\GridForm\Controller\Adminhtml\Items;

class NewAction extends \TrainingMonish\GridForm\Controller\Adminhtml\Items
{

    public function execute()
    {
        $this->_forward('edit');
    }
}
