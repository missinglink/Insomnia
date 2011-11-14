
  _ _|                                 _)      
    |  __ \   __|  _ \  __ `__ \  __ \  |  _` |
    |  |   |\__ \ (   | |   |   | |   | | (   |
  ___|_|  _|____/\___/ _|  _|  _|_|  _|_|\__,_|


Welcome to the Insomnia Framework Beta Release! 

 RELEASE INFORMATION
------------------------

Insomnia Framework beta1

THIS RELEASE IS A DEVELOPMENT RELEASE AND NOT INTENDED FOR PRODUCTION USE.
PLEASE USE AT YOUR OWN RISK.

 FEATURES
------------------------

Insomnia is a PHP 5.3 MVC framework built with one thing in mind, rapidly creating
RESTFUL HTTP/1.1 web services.

The Insomnia Kernel is built with performance and modularity in mind.
A wide range of community modules are available to extend the core functionality.

 MODULES
------------------------

Currently the following modules ship with Insomnia:

Core
----

* [.HTTP](https://github.com/missinglink/Insomnia/tree/master/lib/Insomnia/Kernel/Module/HTTP) -- `Provides HTTP/1.1 functionality.` `Deals with the request [params/headers/body] and speaks HTTP/1.1`

-- CORE --
- HTTP (Provides HTTP/1.1 functionality. Deals with the request [params/headers/body] and speaks HTTP/1.1)
- Mime (Provides format detection [headers/file extensions] and multiple response formats [json/xml/txt/ini/yaml])
- ErrorHandler (Catches exceptions and provides debugging information)

-- COMMUNITY --
- Documentation (Provides an interface to auto-generate documentation)
- Console (Allows script execution via the command line)
- Session (Provides flexible stateful session handling)
- RequestValidator (Provides a basic request validator)
- RestClient (Provides a basic rest client for testing)
- Cors (Adds cross-origin-resources-sharing headers to all HTTP responses)
- Compatibility (Provides a compatibility layer for difficult clients)

 SYSTEM REQUIREMENTS
------------------------

Insomnia Framework beta1 requires PHP 5.3 or later; we recommend using the
latest PHP version whenever possible.

 INSTALLATION
------------------------

Please see INSTALL.txt

 QUESTIONS AND FEEDBACK
------------------------

If you would like to be notified of new releases, you can subscribe to our 
repository on Github https://github.com/missinglink/Insomnia.

Or you can contact the lead developer directly:
Peter Johnson ( https://github.com/missinglink )
