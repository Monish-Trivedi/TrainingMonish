<?php
/**
 *
 * @package     magento2
 * @author      Monish Trivedi
 */

namespace TrainingMonish\StaticBlock\Block;

use Magento\Framework\View\Element\Template;

class Hello extends Template
{
    public function getText() {
        return "Static Block";
    }
}