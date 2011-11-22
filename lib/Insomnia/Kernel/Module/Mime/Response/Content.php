<?php

namespace Insomnia\Kernel\Module\Mime\Response;

class Content
{
    /**#@+
     * Supported mime types
     * @const string
     */
    const TYPE_HTML      = 'text/html',
          TYPE_INI       = 'text/ini',
          TYPE_JSON      = 'application/json',
          TYPE_PLAIN     = 'text/plain',
          TYPE_XHTML     = 'application/xhtml',
          TYPE_XML       = 'application/xml',
          TYPE_XML_TEXT  = 'text/xml',
          TYPE_YAML      = 'application/x-yaml',
          TYPE_YAML_TEXT = 'text/yaml';
    /**#@-*/
}