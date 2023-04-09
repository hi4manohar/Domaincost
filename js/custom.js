function suggested_price_check(d) {
    var d_parts = d.split(".");
    if( d_parts.length == 2 ) {
        var tld_part = document.getElementById("exampleFormControlSelect1").selectedIndex;
        document.getElementById("exampleFormControlSelect1")[tld_part].value = '.' + d_parts[1];
        document.getElementById("domain").value = d_parts[0];
        document.getElementById("domain_search_form").submit();
    } else if( d_parts.length == 3 ) {
        var tld_part = document.getElementById("exampleFormControlSelect1").selectedIndex;
        document.getElementById("exampleFormControlSelect1")[tld_part].value = '.' + d_parts[1] + '.' + d_parts[2];
        document.getElementById("domain").value = d_parts[0];
        document.getElementById("domain_search_form").submit();
    } else {
        alert('Something went wrong, Please try again.');
    }
}


$(document).ready(function() {
    if( $('#updateContainer').length > 0 ) {
        window.wiselinks = new Wiselinks($('#updateContainer'));
    }

    var updateContainer_content = '';

    $(document).off('page:loading').on('page:loading', function(event, $target, render, url) {
        $('.hameid-loader-overlay').show();
        updateContainer_content = $('#updateContainer').html();
        $('#updateContainer').html('');
    });
    $(document).off('page:redirected').on('page:redirected', function(event, $target, render, url) {
        $('.hameid-loader-overlay').hide();
    });
    $(document).off('page:always').on('page:always', function(event, xhr, settings) {
        $('.hameid-loader-overlay').hide();
    });
    $(document).off('page:done').on('page:done', function(event, $target, status, url, data) {
        $('.hameid-loader-overlay').hide();
        ga('set', 'page', url);
        ga('send', 'pageview');
    });
    $(document).off('page:fail').on('page:fail', function(event, $target, status, url, error, code) {
        alert("Sorry! Page could't be loaded");
        $('#updateContainer').html(updateContainer_content);
    });
});