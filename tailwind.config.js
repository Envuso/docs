const defaultTheme = require('tailwindcss/defaultTheme');
const colors       = require('tailwindcss/colors');

module.exports = {
    purge    : [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode : false, // or 'media' or 'class'
    theme    : {

        extend : {
            colors     : {
                gray : colors.gray
            },
            fontFamily : {
                sans : ['Inter var', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    variants : {
        extend : {
            translate : ['group-hover', 'hover'],
            transform : ['group-hover', 'hover'],
        },
    },
    plugins  : [],
};
