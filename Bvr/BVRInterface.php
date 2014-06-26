<?php
/**
 * Created by PhpStorm.
 * Date: 26.06.14
 * Time: 19:30
 *
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */

namespace sirgix\BvrBundle\Bvr;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class AbstractBVR
 *
 * @package sirgix\BvrBundle\Bvr
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
interface BVRInterface
{

    public function getEncodingLine();


    /**
     * Gives back the reference number to print on the BVR
     *
     * @return string
     */
    public function getFormattedReferenceNumber();

    /**
     * @param mixed $amount
     */
    public function setAmount($amount);

    /**
     * @return mixed
     */
    public function getAmount();

    /**
     * @param mixed $referenceNumber
     */
    public function setReferenceNumber($referenceNumber);

    /**
     * Returns the originally given reference number
     *
     * @return mixed
     */
    public function getReferenceNumber();

    /**
     * The possible types are defined as constants of this class
     *
     * @param int $type
     */
    public function setType($type);

    /**
     * @return int
     */
    public function getType();

    /**
     * your address
     *
     * @param mixed $paymentFor
     */
    public function setPaymentFor($paymentFor);

    /**
     * @return mixed
     */
    public function getPaymentFor();

    /**
     * Address of the payer
     *
     * @param mixed $paymentFrom
     */
    public function setPaymentFrom($paymentFrom);

    /**
     * @return mixed
     */
    public function getPaymentFrom();

    /**
     * Your postal account
     *
     * @param mixed $postalAccount
     *
     * @throws Exception
     */
    public function setPostalAccount($postalAccount);

    /**
     * @return mixed
     */
    public function getPostalAccount();
}
