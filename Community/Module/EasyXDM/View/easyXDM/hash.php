<!doctype html>
<html>
    <head>
        <title></title>
        <script type="text/javascript" src="/xdm/easyXDM.js">
            // This should be changed so that it points to the minified version before use in production.
        </script>
        <script type="text/javascript">
            // Update to point to your copy
            easyXDM.DomHelper.requiresJSON("/xdm/json2.js");
        </script>
        <script type="text/javascript">
        
        /* 
         * This is a CORS (Cross-Origin Resource Sharing) and AJAX enabled endpoint for easyXDM.
         * The ACL code is adapted from pmxdr (http://github.com/eligrey/pmxdr/) by Eli Grey (http://eligrey.com/)
         *
         */
        // From http://peter.michaux.ca/articles/feature-detection-state-of-the-art-browser-scripting
        function isHostMethod(object, property){
            var t = typeof object[property];
            return t == 'function' ||
            (!!(t == 'object' && object[property])) ||
            t == 'unknown';
        }
        
        /**
         * Creates a cross-browser XMLHttpRequest object
         * @return {XMLHttpRequest} A XMLHttpRequest object.
         */
        var getXhr = (function(){
            if (isHostMethod(window, "XMLHttpRequest")) {
                return function(){
                    return new XMLHttpRequest();
                };
            }
            else {
                var item = (function(){
                    var list = ["Microsoft", "Msxml2", "Msxml3"], i = list.length;
                    while (i--) {
                        try {
                            item = list[i] + ".XMLHTTP";
                            var obj = new ActiveXObject(item);
                            return item;
                        } 
                        catch (e) {
                        }
                    }
                }());
                return function(){
                    return new ActiveXObject(item);
                };
            }
        }());
        
        // this file is by default set up to use Access Control - this means that it will use the headers set by the server to decide whether or not to allow the call to return
        var useAccessControl = true;
        // always trusted origins, can be exact strings or regular expressions
        var alwaysTrustedOrigins = [(/\.?local\.bnt/), (/xdm1/)];
        
        // instantiate a new easyXDM object which will handle the request 
        var remote = new easyXDM.Rpc({
            local: "/xdm/name.html",
            swf: "/xdm/flash.swf"
        }, {
            local: {
                // define the exposed method
                request: function(config, success, error){
                
                    // apply default values if not set
                    easyXDM.apply(config, {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/x-www-form-urlencoded",
                            "X-Requested-With": "XMLHttpRequest"
                        },
                        success: Function.prototype,
                        error: function(msg){
                            throw new Error(msg);
                        },
                        data: {},
                        timeout: 10 * 1000
                    }, true);
                    
                    var isPOST = config.method == "POST";
                    
                    // convert the data into a format we can send to the server 
                    var pairs = [];
                    for (var key in config.data) {
                        if (config.data.hasOwnProperty(key)) {
                            pairs.push(encodeURIComponent(key) + "=" + encodeURIComponent(config.data[key]));
                        }
                    }
                    var data = pairs.join("&");
                    
                    // create the XMLHttpRequest object
                    var req = getXhr();
                    req.open(config.method, config.url + (isPOST ? "" : "?" + data), true);
                    
                    // apply the request headers
                    for (var prop in config.headers) {
                        if (config.headers.hasOwnProperty(prop) && config.headers[prop]) {
                            req.setRequestHeader(prop, config.headers[prop]);
                        }
                    }
                    
                    // set a timeout
                    var timeout;
                    timeout = setTimeout(function(){
                        req.abort();
                        error({
                            message: "timeout after " + config.timeout + " second",
                            status: 0,
                            data: null,
                            toString: function(){
                                return this.message + " Status: " + this.status;
                            }
                        }, null);
                    }, config.timeout);
                    
                    // check if this origin should always be trusted
                    var alwaysTrusted = false, i = alwaysTrustedOrigins.length;
                    while (i-- && !alwaysTrusted) {
                        if (alwaysTrustedOrigins[i] instanceof RegExp) {
                            alwaysTrusted = alwaysTrustedOrigins[i].test(remote.origin);
                        }
                        else if (typeof alwaysTrustedOrigins[i] == "string") {
                            alwaysTrusted = (remote.origin === alwaysTrustedOrigins[i]);
                        }
                    }
                    
                    
                    // define the onreadystate handler
                    req.onreadystatechange = function(){
                        if (req.readyState == 4) {
                            clearTimeout(timeout);
                            
                            // parse the response headers
                            var rawHeaders = req.getAllResponseHeaders(), headers = {}, headers_lowercase = {}, reHeader = /([\w-_]+):\s+(.*)$/gm, m;
                            while ((m = reHeader.exec(rawHeaders))) {
                                headers_lowercase[m[1].toLowerCase()] = headers[m[1]] = m[2];
                            }
                            
                            if (req.status < 200 || req.status >= 300) {
                                if (useAccessControl) {
                                    error("INVALID_STATUS_CODE");
                                }
                                else {
                                    error("INVALID_STATUS_CODE", {
                                        status: req.status,
                                        data: req.responseText
                                    });
                                }
                            }
                            else {
                            
                                var errorMessage;
                                if (useAccessControl) {
                                    // normalize the valuse access controls
                                    var aclAllowedOrigin = (headers_lowercase["access-control-allow-origin"] || "").replace(/\s/g, "");
                                    var aclAllowedMethods = (headers_lowercase["access-control-allow-methods"] || "").replace(/\s/g, "");
                                    
                                    // determine if origin is trusted
                                    if (alwaysTrusted || aclAllowedOrigin == "*" || aclAllowedOrigin.indexOf(remote.origin) != -1) {
                                        // determine if the request method was allowed
                                        if (aclAllowedMethods && aclAllowedMethods != "*" && aclAllowedMethods.indexOf(config.method) == -1) {
                                            errorMessage = "DISALLOWED_REQUEST_METHOD";
                                        }
                                    }
                                    else {
                                        errorMessage = "DISALLOWED_ORIGIN";
                                    }
                                    
                                }
                                
                                if (errorMessage) {
                                    error(errorMessage);
                                }
                                else {
                                    success({
                                        data: req.responseText,
                                        status: req.status,
                                        headers: headers
                                    });
                                }
                            }
                            // reset the handler
                            req.onreadystatechange = Function.prototype;
                            req = null;
                        }
                    };
                    
                    // issue the request
                    req.send(isPOST ? data : "");
                }
            }
        });
        </script>
    </head>
    <body>
    </body>
</html>
