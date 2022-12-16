<?php
/**
 * Class TestMail
 *
 * PHP version 7
 *
 * @category Risecommerce
 * @package  Risecommerce_Smtp
 * @author   Risecommerce <magento@risecommerce.com>
 * @license  https://www.risecommerce.com  Open Software License (OSL 3.0)
 * @link     https://www.risecommerce.com
 */
namespace Risecommerce\Smtp\Controller\Adminhtml\Smtp;

class TestMail extends \Magento\Backend\App\Action
{
    /**
     * EtatavasoftSmtpHelper
     *
     * @var \Risecommerce\Smtp\Helper\Data
     */
    protected $smtpHelper;

    /**
     * JsonHelper
     *
     * @var \Magento\Framework\Json\Helper\Data
     */
    protected $jsonHelper;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $context    context
     * @param \Risecommerce\Smtp\Helper\Data        $smtpHelper smtpHelper
     * @param \Magento\Framework\Json\Helper\Data $jsonHelper jsonHelper
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Risecommerce\Smtp\Helper\Data $smtpHelper,
        \Magento\Framework\Json\Helper\Data $jsonHelper
    ) {
        $this->smtpHelper = $smtpHelper;
        $this->jsonHelper = $jsonHelper;
        parent::__construct($context);
    }

    /**
     * TestMail action
     *
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        $postParams = $this->getRequest()->getParams();
        $host = $this->smtpHelper->getSmtpHostConfig();
        $port = $this->smtpHelper->getSmtpPortConfig();

        $smtpConf = [
            'host' => $host,
            'port' => $port
        ];

        $auth = strtolower($this->smtpHelper->getSmtpAuthConfig());

        $username = $this->smtpHelper->getSmtpUsername();
        $password = $this->smtpHelper->getSmtpPassword();

        if ($auth != 'none') {
            $smtpConf['auth'] = $auth;
            $smtpConf['username'] = $username;
            $smtpConf['password'] = $password;
        }

        $ssl = $this->smtpHelper->getSmtpSslConfig();

        if ($ssl != 'none') {
            $smtpConf['ssl'] = $ssl;
        }

        $toEmail = $postParams['toEmail'];
        $fromEmail = $postParams['fromEmail'] ? $postParams['fromEmail'] : $username;

        if (!filter_var($toEmail, FILTER_VALIDATE_EMAIL) || (!filter_var($postParams['fromEmail'], FILTER_VALIDATE_EMAIL) && !empty($postParams['fromEmail']))
        ) {
            $result = [
                'success' => 0,
                'message' => 'Please enter valid email address.'
            ];
            return $this->getResponse()->representJson(
                $this->jsonHelper->jsonEncode($result)
            );
        } else {
            $transport = new \Zend_Mail_Transport_Smtp($smtpConf['host'], $smtpConf);
            $mail = new \Zend_Mail();
            $mail->setFrom($fromEmail);
            $mail->addTo($toEmail);

            $returnpath = $this->smtpHelper->getReturnpathValue();
            if ($returnpath) {
                $mail->setReturnPath($returnpath);
            }

            $mail->setSubject(__('TEST EMAIL from Risecommerce SMTP Extension'));

            $mail->setBodyHTML(
                "<p>Hello,</p><p><strong>SMTP configurations are done properly.</strong></p><p>Your store has been successfully connected and ready to send emails with SMTP.</p><p>Thank you for using Risecommerce SMTP extension.</p><p><i>This is an e-mail message sent by Risecommerce SMTP extension while testing the settings for your extension.</i></p>"
            );

            try {
                $mail->send($transport);
                $result = [
                    'success' => 1,
                    'message' => 'Mail sent successfully on ' . $toEmail . '. Please check your Mailbox.'
                ];
                return $this->getResponse()->representJson(
                    $this->jsonHelper->jsonEncode($result)
                );
            } catch (\Exception $e) {
                $result = [
                    'success' => 0,
                    'message' => $e->getMessage()
                ];
                return $this->getResponse()->representJson(
                    $this->jsonHelper->jsonEncode($result)
                );
            }
        }
    }
}
