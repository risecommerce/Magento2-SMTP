<?php
/**
 * Class ProtocolType
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Smtp
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Smtp\Model\Config\Source;

class ProtocolType implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * {@inheritdoc}
     * 
     * @return array
     */
    public function toOptionArray()
    {
        return [
            ['value' => 'none', 'label' => 'NONE'],
            ['value' => 'ssl', 'label' => 'SSL'],
            ['value' => 'tls', 'label' => 'TLS']
        ];
    }
}
