![Insomnia](http://i.imgur.com/J8PFF.jpg)

Welcome to the Insomnia Framework Beta Release! 

Release Information
-------------------

Insomnia Framework beta1

THIS SOFTWARE IS NO LONGER IN ACTIVE DEVELOPMENT, feel free to fork it and do what you will with it.

Features
--------

* Insomnia allows you to quickly and easily create RESTful HTTP/1.1 compliant web services in PHP.
* The Insomnia Kernel is built with performance and modularity in mind.
* The Framework is structured such a way that it enforces separation between the Framework and Application layers.
* Insomnia works well with Doctrine 2, using some of the Doctrine common components such as ClassLoader and AnnotationParser.
* The Framework can be easily combined with libraries from Symfony, Zend, Doctrine, Propel, etc...
* A wide range of community modules are available to extend the core functionality.

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
    `Provides flexible stateful session handling`
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

Please see install.txt

License
------------------------

Insomnia is released under the MIT(Poetic) Software license

    This work 'as-is' we provide.
    No warranty express or implied.
    Therefore, no claim on us will abide.
    Liability for damages denied.

    Permission is granted hereby,
    to copy, share, and modify.
    Use as is fit,
    free or for profit.
    These rights, on this notice, rely. 

Unit Tests
------------------------

Once you've installed PHPUnit you can run the test suite by executing:

    phpunit

Questions & Feedback
------------------------

If you would like to be notified of new releases, you can subscribe to our 
repository on Github https://github.com/missinglink/Insomnia.

Or you can contact the lead developer directly:

Peter Johnson ( https://github.com/missinglink )
