
<pre>

  _ _|                                 _)      
    |  __ \   __|  _ \  __ `__ \  __ \  |  _` |
    |  |   |\__ \ (   | |   |   | |   | | (   |
  ___|_|  _|____/\___/ _|  _|  _|_|  _|_|\__,_|

</pre>

Welcome to the Insomnia Framework Beta Release! 

Release Information
-------------------

Insomnia Framework beta1

THIS RELEASE IS A DEVELOPMENT RELEASE AND NOT INTENDED FOR PRODUCTION USE.

PLEASE USE AT YOUR OWN RISK.

Features
--------

Insomnia is designed to allow developers to quickly and easily create RESTFUL HTTP/1.1 web services in PHP.

The Insomnia Kernel is built with performance and modularity in mind.

A wide range of community modules are available to extend the core functionality.

Modules
-------

Currently the following modules ship with Insomnia:

### Core

* [HTTP](https://github.com/missinglink/Insomnia/tree/master/lib/Insomnia/Kernel/Module/HTTP)
    `Provides HTTP/1.1 functionality.` `Deals with the request [params/headers/body] and speaks HTTP/1.1`
* [Mime](https://github.com/missinglink/Insomnia/tree/master/lib/Insomnia/Kernel/Module/Mime)
    `Provides format detection [headers/file extensions]` `Provides multiple response formats [json/xml/txt/ini/yaml]`
* [ErrorHandler](https://github.com/missinglink/Insomnia/tree/master/lib/Insomnia/Kernel/Module/ErrorHandler)
    `Catches exceptions and provides debugging information`

### Community

* [Documentation](https://github.com/missinglink/Insomnia/tree/master/Community/Module/Documentation)
    `Provides an interface to auto-generate documentation`
* [Console](https://github.com/missinglink/Insomnia/tree/master/Community/Module/Console)
    `Allows script execution via the command line`
* [Session](https://github.com/missinglink/Insomnia/tree/master/Community/Module/Session)
    `Allows script execution via the command line`
* [RequestValidator](https://github.com/missinglink/Insomnia/tree/master/Community/Module/RequestValidator)
    `Provides a basic request validator`
* [RestClient](https://github.com/missinglink/Insomnia/tree/master/Community/Module/RestClient)
    `Provides a basic rest client for testing`
* [Cors](https://github.com/missinglink/Insomnia/tree/master/Community/Module/Cors)
    `Adds cross-origin-resources-sharing headers to all HTTP responses`
* [Compatibility](https://github.com/missinglink/Insomnia/tree/master/Community/Module/Compatibility)
    `Provides a compatibility layer for difficult clients`

System Requirements
------------------------

Insomnia Framework beta1 requires PHP 5.3 or later; we recommend using the
latest PHP version whenever possible.

Installation
------------------------

Please see INSTALL.txt

Questions & Feedback
------------------------

If you would like to be notified of new releases, you can subscribe to our 
repository on Github https://github.com/missinglink/Insomnia.

Or you can contact the lead developer directly:

Peter Johnson ( https://github.com/missinglink )
