BvrBundle
=========

The goal of this bundle is to help you generating swiss BVR+ with Symfony2. For more information and documentation about BVR+ (in french)
go to http://fr.wikipedia.org/wiki/Bulletin_de_versement_avec_num%C3%A9ro_de_r%C3%A9f%C3%A9rence

License
-------
GPL-V2

Installation
============
### Using Composer (Symfony 2.1+)

* Add a new line to your `composer.json` file:
<pre><code>"require": {
    ...
    "sirgix/bvr-bundle": "1.0.*@dev"
}
</code></pre>

* Run a command
<pre><code>php composer.phar update
</code></pre>

* Add a new line to `app/AppKernel.php`:
<pre><code>$bundles = array(
  ...
  new sirgix\BvrBundle\BvrBundle(),
)
</code></pre>


A Quick Start guide
==============================================
### The BVR classes
There are currently 2 bvr classes extending an abstract bvr class.
If you just need to generate the encoding lines, you need to instantiante the bvr class
and fill all the variables:
<pre><code>
        $bvr = new PosteBVR();
        $bvr->setType(PosteBVR::BVR_CHF_PLUS);
        $bvr->setAmount(234.8);
        $bvr->setPaymentFor('test testson
        route des chemins 4
        1000 tonvillage');//Provide an adress. It will be displayed with nl2br
        $bvr->setPaymentFrom(/*see paymentFor*/);
        $bvr->setPostalAccount('17-6358-7');
        $bvr->setReferenceNumber(23456);
        $bvrRender = $this->get("sirgix.bvr.renderer");
        echo $bvrRender->renderBVR($bvr);
</code></pre>

### generate the HTML BVR
I have provided some html for the generation of the bvr html template.
This can be used with mpdf to render a PDF.
It has been tested with https://github.com/tasmanianfox/MpdfPortBundle
<pre><code>
        $bvrRender = $this->get("sirgix.bvr.renderer");
        echo $bvrRender->renderBVR($bvr);//$bvr is an instance of a BVR class
</code></pre>
/!\ THIS IS STILL WIP
### Banks
Some banks have different ways to use the reference number. PosteBVR is the standard one.
UbsBVR implements it for the UBS Bank

Warning
==============================================
This is still work in progress and there could be bugs. Use at your own risk.
