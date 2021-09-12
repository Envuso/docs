import './bootstrap';
import './SideMenu';
import './PageRouting';

import Prism                              from 'prismjs';
import { createActiveGroupEventListener } from './PageActiveGroup';


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
