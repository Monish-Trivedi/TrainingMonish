<?php
/**
 * @package    TrainingMonish_GridForm
 * @author     monish.trivedi@krishtechnolabs.com
 */

namespace TrainingMonish\GridForm\Model\ResourceModel\GridForm;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'gridform_id';
    /**
     * Define model & resource model
     */
    protected function _construct()
    {
        $this->_init(
            'TrainingMonish\GridForm\Model\GridForm',
            'TrainingMonish\GridForm\Model\ResourceModel\GridForm'
        );
    }
}