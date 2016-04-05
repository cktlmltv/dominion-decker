<script type='text/javascript'>
    $("#btn-gen").on("click", function () {
        var exp = new Array();
        var pref = new Array();
        $('input:checkbox[name=expansions]:checked').each(function ()
        {
            exp.push($(this).val());
        });
        $('input:checkbox[name=prefs]:checked').each(function ()
        {
            pref.push($(this).val());
        });
        $.post('<?= BASE_URL ?>decker/', {"expansion": exp, "pref": pref}, function (res) {
            $('.deck').html(res);
            try {
            } catch (x) {
            }
            $('.deck').fadeIn()
        });
    });
</script>
</body>
</html>