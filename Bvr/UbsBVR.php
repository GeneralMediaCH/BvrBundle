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
     * @param       $params
     *
     * @throws \Exception if client id is empty
     *
     * @return void
     */
    public function setReferenceNumber($referenceNumber, $params = null)
    {
        if (!is_array($params)) {
            $ubsClientId = $params;
        } else {
            $ubsClientId = $params['ubsclientid'];
        }
        if (''.$ubsClientId == '') {
            throw new \Exception("A client id is necessary for ubs bvrs");
        }

        $ref = sprintf('%06d', $ubsClientId);
        $ref .= sprintf('%020d', $referenceNumber);

        $this->referenceNumber = $ref;
    }
}
