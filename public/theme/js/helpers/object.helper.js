function parseAliasNamePermission(aliasName) {
    const splitAliasName = aliasName !== null ?
        aliasName.split('.') : Array(3).fill('');

    return {
        menu: splitAliasName[0] || '',
        submenu: splitAliasName[1] || '',
        action: splitAliasName[2] || '',
    }
}

const objHelper = {
    parseAliasNamePermission,
};

export default objHelper;