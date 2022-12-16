<?php
/**
 * Class Data
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Smtp
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Smtp\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\ProductMetadataInterface;
use Magento\Framework\Encryption\EncryptorInterface;
use Magento\Store\Model\StoreManagerInterface;


class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     * Constructor
     * 
     * @param Context                  $context         context
     * @param ProductMetadataInterface $productMetadata productMetadata
     * @param EncryptorInterface       $encryptor       encryptor
     * @param StoreManagerInterface    $storeManager    storeManager
     */
    public function __construct(
        Context $context, 
        ProductMetadataInterface $productMetadata, 
        EncryptorInterface $encryptor, 
        StoreManagerInterface $storeManager
    ) {
        parent::__construct($context);
        $this->productMetadata = $productMetadata;
        $this->_encryptor = $encryptor;
        $this->storeManager = $storeManager;
    }

    /**
     * Return config value
     * 
     * @param string   $configPath configPath
     * @param int|null $storeId    storeId
     * 
     * @return mixed
     */
    public function getConfig($configPath, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            $configPath,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE, 
            $storeId
        );
    }

    /**
     * Return if Email is enable or not
     * 
     * @return mixed
     */
    public function getIsEmailEnabled()
    {
        return $this->getConfig(
            'risecommerce_smtp/general/enable', 
            $this->getStoreId()
        );
    }

    /**
     * Return returnPath is set or not
     * 
     * @return mixed
     */
    public function getIsSetReturnpath()
    {
        return $this->getConfig(
            'risecommerce_smtp/general/set_return_path', 
            $this->getStoreId()
        );
    }

    /**
     * Return returnPath email
     * 
     * @return mixed
     */
    public function getReturnpathValue()
    {
        return $this->getConfig(
            'risecommerce_smtp/general/return_path_email', 
            $this->getStoreId()
        );
    }

    /**
     * Return smtp host
     * 
     * @return mixed
     */
    public function getSmtpHostConfig()
    {
        return $this->getConfig(
            'risecommerce_smtp/general/host', 
            $this->getStoreId()
        );
    }

    /**
     * Return smtp port
     * 
     * @return mixed
     */
    public function getSmtpPortConfig()
    {
        return $this->getConfig(
            'risecommerce_smtp/general/port', 
            $this->getStoreId()
        );
    }

    /**
     * Return smtp authentication method
     * 
     * @return mixed
     */
    public function getSmtpAuthConfig()
    {
        return $this->getConfig(
            'risecommerce_smtp/general/auth', 
            $this->getStoreId()
        );
    }

    /**
     * Return smtp autentication protocol
     * 
     * @return mixed
     */
    public function getSmtpSslConfig()
    {
        return $this->getConfig(
            'risecommerce_smtp/general/ssl', 
            $this->getStoreId()
        );
    }

    /**
     * Return smtp authentication username
     * 
     * @return mixed
     */
    public function getSmtpUsername()
    {
        return $this->getConfig(
            'risecommerce_smtp/general/username', 
            $this->getStoreId()
        );
    }

    /**
     * Return smtp authentication password
     * 
     * @return mixed
     */
    public function getSmtpPassword()
    {
        return $this->_encryptor->decrypt(
            $this->getConfig(
                'risecommerce_smtp/general/password', 
                $this->getStoreId()
            )
        );
    }

    /**
     * Return current magento version
     * 
     * @return mixed
     */
    public function getMagentoVersion()
    {
        return $this->productMetadata->getVersion();
    }

    /**
     * Return current store id
     * 
     * @return mixed
     */
    public function getStoreId()
    {
        return $this->storeManager->getStore()->getId();
    }
}
