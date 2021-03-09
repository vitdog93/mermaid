'use strict';

$(document).ready(function () {
    /*---------------------------------------
        jQuery Sparklines
    ----------------------------------------*/

    // Quick stats bar chart
    if($('.sparkline-bar-stats')[0]) {
        $('.sparkline-bar-stats').sparkline('html', {
            type: 'bar',
            height: 36,
            barWidth: 3,
            barColor: '#fff',
            barSpacing: 2
        });
    }
});