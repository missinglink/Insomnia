<?php

namespace Insomnia\Kernel\Module\Mime;

use Response\Renderer\ViewException;

abstract class Layout extends View
{
    protected $view;
    
    public function render()
    {
        if( false === ( $this->getView() instanceof View ) )
        {
            throw new ViewException( 'Layout must have a view' );
        }
        
        // Merge in stylesheets & scripts from the view, merge title
        $this->setScripts( array_merge( $this->getScripts(), $this->getView()->getScripts() ) );
        $this->setStylesheets( array_merge( $this->getStylesheets(), $this->getView()->getStylesheets() ) );
        $this->setTitle( $this->getView()->getTitle() );

        // Get response from view
        $this->setResponse( $this->getView()->getResponse() );
        
        parent::render();
    }
    
    public function getView()
    {
        return $this->view;
    }

    public function setView( View $view )
    {
        $this->view = $view;
    }
}