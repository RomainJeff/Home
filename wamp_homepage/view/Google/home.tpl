<div class="modal" id="googlesearch">
    <div class="search">
        <div class="input">
            <input type="text" placeholder="Tapez votre recherche..." id="googlesearch_words">
            <a class="close" onclick="GoogleSearch();">
                &#10060;
            </a>
        </div>
    </div>
</div>

<script>
    function GoogleSearch ()
    {
        $('#googlesearch').fadeToggle();
        $('#googlesearch_words').val('');
    }

    $('#googlesearch_words').keydown(function (e) {
        if (e.which == 13) {
            var query = $('#googlesearch_words').val();
            window.open('https://www.google.fr/webhp#q='+ query);
            GoogleSearch();
        }
    });
</script>