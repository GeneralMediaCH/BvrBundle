<?php
/**
 * Created by PhpStorm.
 * Date: 26.06.14
 * Time: 19:22
 *
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */

namespace sirgix\BvrBundle\Service;

use sirgix\BvrBundle\Bvr\BVRInterface;

/**
 * Class BvrService
 *
 * @package sirgix\BvrBundle\Service
 * @author  Sergio Mendolia <sergio@mendolia.ch>
 */
class BvrService
{
    protected $twig;

    /**
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * Gives back a formatted BVR template in HTML for rendreing in pdf?
     *
     * @param BVRInterface $bvr
     *
     * @return string html
     */
    public function renderBVR(BVRInterface $bvr)
    {
        return $this->twig->render("@Bvr/Default/index.html.twig", array('bvr' => $bvr));
    }
}
