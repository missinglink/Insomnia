function stringify(object, pad){
    var indent = '   '
    if (!pad) pad = ''
    var out = ''
    if (object instanceof Array){
        out += '[\n'
        for (var i=0; i<object.length; i++){
            out += pad + indent + stringify(object[i], pad + indent) + '\n'
        }
        out += pad + ']'
    }else if (object instanceof Object){
        out += '{\n'
        for (var i in object){
            out += pad + indent + i + ': ' + stringify(object[i], pad + indent) + '\n'
        }
        out += pad + '}'
    }else{
        out += object
    }
    return out
}