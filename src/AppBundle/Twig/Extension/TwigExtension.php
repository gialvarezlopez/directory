<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TwigExtension
 *
 * @author Owner
 */
/*
class TwigExtension {
	//put your code here
}
*/

namespace AppBundle\Twig\Extension;

//use \Twig_Filter_Function;
//use \Twig_Filter_Method;


class TwigExtension extends \Twig_Extension
{

    /**
     * Return the functions registered as twig extensions
     * 
     * @return array
     */
    public function getFunctions()
    {
		
        return array(
            new \Twig_SimpleFunction('file_exists', 'file_exists'),
        );
		
    }

    public function getName()
    {
        return 'app_file';
		//return 'common_file_exists';
    }
}