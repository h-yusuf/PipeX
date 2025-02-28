function templateString(decodeString, substitution, isRemove = false) {
    if (!substitution) return decodeString;

    if (typeof decodeString !== 'string') {
        return decodeString;
    }

    let arrArgs = [];

    if (Array.isArray(substitution)) {
        arrArgs = substitution;
    } else if (typeof substitution === 'object') {
        arrArgs = Object.keys(substitution);
    }

    return decodeString.replace(/\{(\w*)\}/g, function(match, key) {
        for (let i = 0; i < arrArgs.length; i++) {
            if (typeof substitution === 'object' && typeof substitution[key] !== 'undefined') {
                return substitution[key];
            } else if (
                Array.isArray(substitution) &&
                typeof arrArgs[i] === 'object' &&
                typeof arrArgs[i][key] !== 'undefined'
            ) {
                return arrArgs[i][key];
            } else if (Array.isArray(substitution) && typeof arrArgs[i] === 'object') {
                return arrArgs[key];
            }

            if (isRemove) return '';
        }

        return match;
    });
}


const strHelper = {
    templateString,
};

export default strHelper;