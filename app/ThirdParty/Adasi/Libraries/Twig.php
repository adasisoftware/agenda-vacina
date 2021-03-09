<?php
/**
 * Adasi Express
 * Utilities package used in Adasi Software's CodeIgniter 4 projects
 * 
 * Twig library for CodeIgniter 4
 * 
 * @author Ricardo Cerqueira <ricardo@adasi.com.br>
 * @link https://www.adasi.com.br
 */
namespace Adasi\Libraries;

use CodeIgniter\Exceptions\PageNotFoundException;
use Twig_Environment;
use Twig_Error_Loader;
use Twig_Extension_Debug;
use Twig_Loader_Filesystem;

class Twig
{
    /**
     * @var \Twig_Environment
     */
    private $environment;

    /**
    * @var array Functions to add to Twig
    */
    private $functions_asis = [ 'base_url', 'csrf_token', 'csrf_hash', 'menu' ];
    
    /**
     * Twig constructor.
     */
    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(APPPATH . 'Views');

        $this->environment = new Twig_Environment($loader, [
            'autoescape' => false
        ]);

        $this->addFunctions();
        $this->addFilters();
        $this->addGlobal('session',\Config\Services::session());
        $this->addGlobal('user',\Config\Services::session()->get('user'));
    }

    /**
     * Add php functions to twig
     *
     * @return void
     */
    protected function addFunctions()
    {
        // as is functions
        foreach ($this->functions_asis as $function) {
            if (function_exists($function)) {
                $this->environment->addFunction(new \Twig_SimpleFunction($function, $function));
            }
        }
    }

    /**
     * Add filters to twig
     * 
     * @return void
     */
    protected function addFilters()
    {             
        $filters = [
            'hash_encode' => function($value) { return \hashEncode($value); },
            'hash_decode' => function($value) { return \hashDecode($value); },
            'mask_cpf_cnpj' => function($value) { return \maskCpfCnpj($value); },
        ];
        foreach ($filters as $name => $filter)
            $this->environment->addFilter(new \Twig\TwigFilter($name, $filter));
    }

    /**
    * Registers a Global
    *
    * @param string $name  The global name
    * @param mixed  $value The global value
    */
    public function addGlobal( $name, $value )
    {
        $this->environment->addGlobal( $name, $value );
    }


    /**
     * Twig render file
     *
     * @param string $page
     * @param array $data
     * @return string
     */
    public function render($page, $data = [])
    {
        try {
            $template = $this->environment->load($page);
        } catch (Twig_Error_Loader $error_Loader) {
            throw new PageNotFoundException($error_Loader);
        }

        return $template->render($data);
    }

}