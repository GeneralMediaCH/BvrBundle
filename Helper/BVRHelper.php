<?php
namespace sirgix\BvrBundle\Helper;

/**
 * Class BVRHelper is used to generate coing ligns and ref numbers
 *
 * @package sirgix\BvrBundle\Helper
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class BVRHelper
{
    private $type = '04';
    private $montant;
    private $identClient = '200002';
    private $numRef;
    private $numparticipant = '010040438';

    private $moduloTable = array(
        array(0, 9, 4, 6, 8, 2, 7, 1, 3, 5),
        array(9, 4, 6, 8, 2, 7, 1, 3, 5, 0),
        array(4, 6, 8, 2, 7, 1, 3, 5, 0, 9),
        array(6, 8, 2, 7, 1, 3, 5, 0, 9, 4),
        array(8, 2, 7, 1, 3, 5, 0, 9, 4, 6),
        array(2, 7, 1, 3, 5, 0, 9, 4, 6, 8),
        array(7, 1, 3, 5, 0, 9, 4, 6, 8, 2),
        array(1, 3, 5, 0, 9, 4, 6, 8, 2, 7),
        array(3, 5, 0, 9, 4, 6, 8, 2, 7, 1),
        array(5, 0, 9, 4, 6, 8, 2, 7, 1, 3)
    );
    private $moduloTableKey = array(0, 9, 8, 7, 6, 5, 4, 3, 2, 1);

    public function checkDigit($number)
    {
        $number = str_split($number, 1);
        $tmp    = 0;
        for ($i = 0; $i < count($number); $i++) {
            $tmp = $this->moduloTable[$tmp][$number[$i]];
        }

        return $this->moduloTableKey[$tmp];
    }

    public function getLigneCodage()
    {
        $chf       = explode('.', $this->montant);
        $firstpart = $this->type . sprintf('%08d', $chf[0]) . $chf[1] . ($chf[1] < 10 ? '0' : '');

        $secondpart = $this->identClient . sprintf('%020d', $this->numRef);

        return $firstpart . $this->getCheckDigit($firstpart) . '>' . $secondpart . $this->getCheckDigit(
            $secondpart
        ) . '+ ' . $this->numparticipant . '>';
    }

    public function getNumeroRef()
    {

        $ref = sprintf('%025d', $this->numRef . $this->getCheckDigit($this->numRef));

        return '00 ' . implode(' ', str_split($ref, 5));
    }
}
