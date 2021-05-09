import 'bootstrap';
import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';
import 'jquery-ui/ui/widgets/dialog.js';
import 'jquery-ui/ui/widgets/autocomplete.js';
import 'jquery-ui/ui/widgets/spinner.js';

import 'jquery-ui/themes/base/all.css';
$('#datepicker').datepicker();
