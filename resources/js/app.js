require('./bootstrap');
require('./sidemenu');

window.hljs = require('highlight.js');
import 'highlight.js/styles/atom-one-dark.css';

//hljs.configure({
//    classPrefix : 'code-container'
//})
hljs.highlightAll();
//
//document.querySelectorAll('.code-container').forEach(block => {
//    hljs.highlightBlock(block);
//});



