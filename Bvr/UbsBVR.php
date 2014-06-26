<?php
/**
 * Created by PhpStorm.
 * Date: 26.06.14
 * Time: 19:30
 *
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */

namespace sirgix\BvrBundle\Bvr;


/**
 * Class PosteBVR
 *
 * @package sirgix\BvrBundle\Bvr
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class UbsBVR extends AbstractBVR
{
    /**
     * At UBS they use their internal client ID inside the ref number
     *
     * @param mixed $referenceNumber
     * @param       $ubsClientId
     *
     * @return void
     */
    public function setReferenceNumber($referenceNumber, $ubsClientId)
    {
        $ref = sprintf('%06d', $ubsClientId);
        $ref .= sprintf('%020d', $referenceNumber);
        $ref .= $this->helper->checkDigit($ref);

        $this->referenceNumber = $ref;
    }
}
