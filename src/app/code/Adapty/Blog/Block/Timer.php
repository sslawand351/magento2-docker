<?php

namespace Adapty\Blog\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class Timer extends Template
{
    public function __construct(
        Context $context
    ) {
		parent::__construct($context);
	}
}
