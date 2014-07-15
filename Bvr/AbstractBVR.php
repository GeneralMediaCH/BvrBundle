<?php
/**
 * Created by PhpStorm.
 * Date: 26.06.14
 * Time: 19:30
 *
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */

namespace sirgix\BvrBundle\Bvr;

use sirgix\BvrBundle\Helper\BVRHelper;
use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class AbstractBVR
 *
 * @package sirgix\BvrBundle\Bvr
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
abstract class AbstractBVR implements BVRInterface
{
    const BVR_CHF = '01'; // = BVR en CHF
    const BVR_CHF_RBT = '03'; // = BVR-Rbt en CHF
    const BVR_CHF_PLUS = '04'; // = BVR+ en CHF
    const BVR_CHF_SELF = '11'; // = BVR en CHF pour propre compte (chiffre 3.3.4)
    const BVR_CHF_PLUS_SELF = '14'; // = BVR+ en CHF pour propre compte (chiffre 3.3.4)
    const BVR_EUR = '21'; // = BVR en EUR
    const BVR_EUR_SELF = '23'; // = BVR en EUR pour propre compte (chiffre 3.3.4)
    const BVR_EUR_PLUS = '31'; // = BVR+ en EUR
    const BVR_EUR_PLUS_SELF = '33'; // = BVR+ en EUR pour propre compte (chiffre 3.3.4

    protected $type = self::BVR_CHF_PLUS;
    protected $amount;
    protected $referenceNumber;
    protected $participantNumber;
    protected $helper;

    protected $paymentFor;
    protected $paymentFrom;
    protected $postalAccount;

    /**
     *
     */
    public function __construct()
    {
        $this->helper = new BVRHelper();
    }

    /**
     * Gets back the line to print on the bottome of the BVR
     *
     * @return string
     */
    public function getEncodingLine()
    {
        $cents = $this->amount * 100;
        $firstpart = $this->type . sprintf('%08s', $cents);

        $secondpart = sprintf('%027s', $this->referenceNumber);

        $encondingLine =
            $firstpart . $this->helper->checkDigit($firstpart) . '>' .
            $secondpart . $this->helper->checkDigit($secondpart) . '+ ' .
            $this->participantNumber . '>';

        return $encondingLine;
    }


    /**
     * Gives back the reference number to print on the BVR
     *
     * @return string
     */
    public function getFormattedReferenceNumber()
    {
        $ref = sprintf('%027s', $this->referenceNumber . $this->helper->checkDigit($this->referenceNumber));

        //2 first digits are separated:
        $first2 = substr($ref, 0, 2);
        $last25 = substr($ref, 2, 25);

        return $first2 . ' ' . implode(' ', str_split($last25, 5));
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $referenceNumber
     * @param array $params : must be empty unless specified
     */
    public function setReferenceNumber($referenceNumber,$params=null)
    {
        $this->referenceNumber = $referenceNumber;
    }

    /**
     * Returns the originally given reference number
     *
     * @return mixed
     */
    public function getReferenceNumber()
    {
        return $this->referenceNumber;
    }

    /**
     * The possible types are defined as constants of this class
     *
     * @param int $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * your address
     *
     * @param mixed $paymentFor
     */
    public function setPaymentFor($paymentFor)
    {
        $this->paymentFor = $paymentFor;
    }

    /**
     * @return mixed
     */
    public function getPaymentFor()
    {
        return $this->paymentFor;
    }

    /**
     * Address of the payer
     *
     * @param mixed $paymentFrom
     */
    public function setPaymentFrom($paymentFrom)
    {
        $this->paymentFrom = $paymentFrom;
    }

    /**
     * @return mixed
     */
    public function getPaymentFrom()
    {
        return $this->paymentFrom;
    }

    /**
     * Your postal account
     *
     * @param mixed $postalAccount
     *
     * @throws Exception
     */
    public function setPostalAccount($postalAccount)
    {
        $this->postalAccount = $postalAccount;

        $formatting = explode('-', $postalAccount);
        if (count($formatting) != 3) {
            throw new Exception('The account number is not correctly formatted');
        }

        $participantNumber = sprintf('%02d', $formatting[0]);
        $participantNumber .= sprintf('%06d', $formatting[1]);
        $participantNumber .= $formatting[2];

        if (strlen($participantNumber) != 9) {
            throw new Exception('The account number is incorrect');
        }

        $this->participantNumber = $participantNumber;
    }

    /**
     * @return mixed
     */
    public function getPostalAccount()
    {
        return $this->postalAccount;
    }


}
