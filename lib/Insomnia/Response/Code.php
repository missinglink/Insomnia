<?php

namespace Insomnia\Response;

final class Code
{
     // [Informational 1xx]
     const HTTP_CONTINUE                        = '100 Continue';
     const HTTP_SWITCHING_PROTOCOLS             = '101 Switching Protocols';

     // [Successful 2xx]
     const HTTP_OK                              = '200 OK';
     const HTTP_CREATED                         = '201 Created';
     const HTTP_ACCEPTED                        = '202 Accepted';
     const HTTP_NONAUTHORITATIVE_INFORMATION    = '203 Non-Authoritative Information';
     const HTTP_NO_CONTENT                      = '204 No Content';
     const HTTP_RESET_CONTENT                   = '205 Reset Content';
     const HTTP_PARTIAL_CONTENT                 = '206 Partial Content';

     // [Redirection 3xx]
     const HTTP_MULTIPLE_CHOICES                = '300 Multiple Choices';
     const HTTP_MOVED_PERMANENTLY               = '301 Moved Permanently';
     const HTTP_FOUND                           = '302 Found';
     const HTTP_SEE_OTHER                       = '303 See Other';
     const HTTP_NOT_MODIFIED                    = '304 Not Modified';
     const HTTP_USE_PROXY                       = '305 Use Proxy';
     const HTTP_UNUSED                          = '306 (Unused)';
     const HTTP_TEMPORARY_REDIRECT              = '307 Temporary Redirect';
     
     // [Client Error 4xx]
     const HTTP_BAD_REQUEST                     = '400 Bad Request';
     const HTTP_UNAUTHORIZED                    = '401 Unauthorized';
     const HTTP_PAYMENT_REQUIRED                = '402 Payment Required';
     const HTTP_FORBIDDEN                       = '403 Forbidden';
     const HTTP_NOT_FOUND                       = '404 Not Found';
     const HTTP_METHOD_NOT_ALLOWED              = '405 Method Not Allowed';
     const HTTP_NOT_ACCEPTABLE                  = '406 Not Acceptable';
     const HTTP_PROXY_AUTHENTICATION_REQUIRED   = '407 Proxy Authentication Required';
     const HTTP_REQUEST_TIMEOUT                 = '408 Request Timeout';
     const HTTP_CONFLICT                        = '409 Conflict';
     const HTTP_GONE                            = '410 Gone';
     const HTTP_LENGTH_REQUIRED                 = '411 Length Required';
     const HTTP_PRECONDITION_FAILED             = '412 Precondition Failed';
     const HTTP_REQUEST_ENTITY_TOO_LARGE        = '413 Request Entity Too Large';
     const HTTP_REQUEST_URI_TOO_LONG            = '414 Request-URI Too Long';
     const HTTP_UNSUPPORTED_MEDIA_TYPE          = '415 Unsupported Media Type';
     const HTTP_REQUESTED_RANGE_NOT_SATISFIABLE = '416 Requested Range Not Satisfiable';
     const HTTP_EXPECTATION_FAILED              = '417 Expectation Failed';
     
     // [Server Error 5xx]
     const HTTP_INTERNAL_SERVER_ERROR           = '500 Internal Server Error';
     const HTTP_NOT_IMPLEMENTED                 = '501 Not Implemented';
     const HTTP_BAD_GATEWAY                     = '502 Bad Gateway';
     const HTTP_SERVICE_UNAVAILABLE             = '503 Service Unavailable';
     const HTTP_GATEWAY_TIMEOUT                 = '504 Gateway Timeout';
     const HTTP_VERSION_NOT_SUPPORTED           = '505 HTTP Version Not Supported';
}