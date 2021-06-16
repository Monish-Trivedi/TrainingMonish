<?php
/**
 * @package    TrainingMonish_GridForm
 * @author     monish.trivedi@krishtechnolabs.com
 */

namespace TrainingMonish\GridForm\Model;

use Magento\Framework\Model\AbstractModel;

class GridForm extends AbstractModel
{
    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init('TrainingMonish\GridForm\Model\ResourceModel\GridForm');
    }
}