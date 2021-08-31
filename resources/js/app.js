require('./bootstrap');
require('./sidemenu');

//window.hljs = require('highlight.js');
//import 'highlight.js/styles/ir-black.css';
//import javascript from 'highlight.js/lib/languages/javascript';
//import typescript from 'highlight.js/lib/languages/typescript';
//import shell      from 'highlight.js/lib/languages/shell';
//
//
//hljs.registerLanguage('javascript', javascript);
//hljs.registerLanguage('typescript', typescript);
//hljs.registerLanguage('shell', shell);
//
//hljs.highlightAll();

import Prism from 'prismjs';


Prism.manual = true;

Prism.plugins.NormalizeWhitespace.setDefaults({
    'remove-trailing'          : true,
    'remove-indent'            : true,
    'left-trim'                : true,
    'right-trim'               : true,
    'break-lines'              : 160,
    'indent'                   : 0,
    'remove-initial-line-feed' : false,
    'tabs-to-spaces'           : 4,
    'spaces-to-tabs'           : 4
});
Prism.highlightAll();


