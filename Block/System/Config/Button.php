<?php
/**
 * Class Button
 *
 * PHP version 7 & 8
 *
 * @category Risecommerce
 * @package  Risecommerce_Smtp
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Smtp\Block\System\Config;

use Magento\Framework\Data\Form\Element\AbstractElement;

class Button extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * Block template
     *  
     * @var string
     */
    protected $_template = 'Risecommerce_Smtp::system/config/button.phtml';

    /**
     * Constructor
     * 
     * @param \Magento\Backend\Block\Template\Context $context context
     * @param array                                   $data    data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }

    /**
     * Remove scope label
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element element
     * 
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * Return element html
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element element
     * 
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }

    /**
     * Return ajax url
     * 
     * @return string
     */
    public function getAjaxUrl()
    {
        return $this->getUrl('risecommerce_smtp/smtp/testmail');
    }

    /**
     * Generate button html
     *
     * @return string
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Button'
        )->setData(
            [
            'id' => 'test_risecommerce_smtp_mail',
            'label' => __('Test Mail'),
            ]
        );

        return $button->toHtml();
    }
}
