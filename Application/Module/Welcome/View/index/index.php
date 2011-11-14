<style>
    body { background-color: #F8F8F8; padding:20px 20px }
    h2, h3 { color: #333; font-family: sans-serif; font-size: 1/4em; }
</style>

<img src="http://i.imgur.com/J8PFF.jpg" alt="Insomnia" style="margin-left:-10px;" />

<br /><br />
<p>Welcome to the Insomnia Framework Beta Release!</p>

<h2>Release Information</h2>

<p>Insomnia Framework beta1</p>

<p>THIS RELEASE IS STILL IN ACTIVE DEVELOPMENT.</p>

<h2>Features</h2>

<ul>
<li>Insomnia allows you to quickly and easily create RESTful HTTP/1.1 compliant web services in PHP.</li>
<li>The Insomnia Kernel is built with performance and modularity in mind.</li>
<li>The Framework is structured such a way that it enforces separation between the Framework and Application layers.</li>
<li>Insomnia works well with Doctrine 2, using some of the Doctrine common components such as ClassLoader and AnnotationParser.</li>
<li>The Framework can be easily combined with libraries from Symfony, Zend, Doctrine, Propel, etc...</li>
<li>A wide range of community modules are available to extend the core functionality.</li>
</ul>

<h2>Modules</h2>

<p>Currently the following modules ship with Insomnia:</p>

<h3>Core</h3>

<ul>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/lib/Insomnia/Kernel/Module/HTTP">HTTP</a>
    Provides HTTP/1.1 functionality. Deals with the request [params/headers/body] and speaks HTTP/1.1</li>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/lib/Insomnia/Kernel/Module/Mime">Mime</a>
    Provides format detection [headers/file extensions] Provides multiple response formats [json/xml/txt/ini/yaml]</li>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/lib/Insomnia/Kernel/Module/ErrorHandler">ErrorHandler</a>
    Catches exceptions and provides debugging information</li>
</ul>

<h3>Community</h3>

<ul>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/Community/Module/Documentation">Documentation</a>
    Provides an interface to auto-generate documentation</li>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/Community/Module/Console">Console</a>
    Allows script execution via the command line</li>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/Community/Module/Session">Session</a>
    Provides flexible stateful session handling</li>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/Community/Module/RequestValidator">RequestValidator</a>
    Provides a basic request validator</li>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/Community/Module/RestClient">RestClient</a>
    Provides a basic rest client for testing</li>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/Community/Module/Cors">Cors</a>
    Adds cross-origin-resources-sharing headers to all HTTP responses</li>
<li><a href="https://github.com/missinglink/Insomnia/tree/master/Community/Module/Compatibility">Compatibility</a>
    Provides a compatibility layer for difficult clients</li>
</ul>

<h2>System Requirements</h2>

<p>Insomnia Framework beta1 requires PHP 5.3 or later; we recommend using the
latest PHP version whenever possible.</p>

<h2>Installation</h2>

<p>Please see INSTALL.txt</p>

<h2>Questions & Feedback</h2>

<p>If you would like to be notified of new releases, you can subscribe to our 
repository on Github <a href="https://github.com/missinglink/Insomnia">https://github.com/missinglink/Insomnia</a>.</p>

<p>Or you can contact the lead developer directly:

<p>Peter Johnson ( <a href="https://github.com/missinglink">https://github.com/missinglink</a> )</p>
