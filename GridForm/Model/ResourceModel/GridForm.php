<?php
/**
 * @package    TrainingMonish_GridForm
 * @author     monish.trivedi@krishtechnolabs.com
 */

namespace TrainingMonish\GridForm\Model\ResourceModel;

class GridForm extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('trainingmonish_gridform', 'gridform_id');   //here "trainingmonish_gridform" is table name and "gridform_id" is the primary key of custom table
    }
}