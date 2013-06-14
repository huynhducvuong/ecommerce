<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\Component\Payment;

use Sonata\Component\Order\OrderInterface;

/**
 * The Transaction class represents a callback request from the bank.
 *
 * The object contains :
 *   - the order            : the related order
 *   - the transaction_id   : the transaction token from the bank
 *   - the state            : the current state of the transaction, only OK or KO
 *   - the status           : the current status of the transaction
 *   - the error code       : the current error code of the transaction from the payment handler
 *
 */
interface TransactionInterface
{
    const STATE_OK = 1;
    const STATE_KO = 2;

    const STATUS_ORDER_UNKNOWN    = -1;  // the order is unknow
    const STATUS_OPEN             = 0;  // created but not validated
    const STATUS_PENDING          = 1;  // the bank send a 'pending-like' status, so the payment is not validated, but the user payed
    const STATUS_VALIDATED        = 2;  // the bank confirm the payment
    const STATUS_CANCELLED        = 3;  // the user cancelled the payment
    const STATUS_UNKNOWN          = 4;  // the bank sent a unknown code ...
    const STATUS_ERROR_VALIDATION = 9;  // something wrong happen when the bank validate the postback
    const STATUS_WRONG_CALLBACK   = 10; // something wrong is sent from the bank. hack or the bank change something ...
    const STATUS_WRONG_REQUEST    = 11; // the callback request is not valid
    const STATUS_ORDER_NOT_OPEN   = 12; // the order is not open (so a previous transaction already alter the order)

    /**
     * @abstract
     * @param  \Sonata\Component\Order\OrderInterface $order
     * @return void
     */
    public function setOrder(OrderInterface $order);

    /**
     * @abstract
     * @return \Sonata\Component\Order\OrderInterface
     */
    public function getOrder();

    /**
     * @abstract
     * @param  integer $state
     * @return void
     */
    public function setState($state);

    /**
     *
     * @return integer
     */
    public function getState();

    /**
     * @param integer $transactionId
     */
    public function setTransactionId($transactionId);

    /**
     *
     * @return integer
     */
    public function getTransactionId();

    /**
     *
     * @return boolean
     */
    public function isValid();

    /**
     *
     * @param array $parameters
     */
    public function setParameters(array $parameters);

    /**
     * @return array
     */
    public function getParameters();

    /**
     *
     * @param  string $name
     * @param  mixed  $default
     * @return mixed
     */
    public function get($name, $default = null);

    /**
     *
     * @param integer $statusCode
     */
    public function setStatusCode($statusCode);

    /**
     * return integer
     */
    public function getStatusCode();

    /**
     * return status list
     *
     * @return array
     */
    public static function getStatusList();

    /**
     * @abstract
     * @param  \DateTime|null $createdAt
     * @return void
     */
    public function setCreatedAt(\DateTime $createdAt = null);

    /**
     * @abstract
     * @return \DateTime
     */
    public function getCreatedAt();

    /**
     * @abstract
     * @param  integer $paymentCode
     * @return void
     */
    public function setPaymentCode($paymentCode);

    /**
     * @abstract
     * @return string
     */
    public function getPaymentCode();

    /**
     * @abstract
     * @return string
     */
    public function getInformation();

    /**
     * @abstract
     * @param string $message
     */
    public function setInformation($message);

    /**
     * @abstract
     * @param $message
     */
    public function addInformation($message);

    /**
     * @abstract
     */
    public function getStatusName();
}
