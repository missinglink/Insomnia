<?php

namespace Insomnia\Kernel\Module\HTTP\Request\Plugin;

use \Insomnia\Pattern\Observer;

/**
 * Merge request parameters from the $_REQUEST superglobal in to the Insomnia 
 * request object.
 */
class ParamParser extends Observer
{
    /* @var $request \Insomnia\Request */
    public function update( \SplSubject $request )
    {
			// Merge in to request object
			$request->mergeParams( array_filter( $_REQUEST, function($value) {
				return $value !== '';
			} ) );
    }
}