<html>
    <head>
        <title>Dominion Decker</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
        <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
        <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="<?=BASE_URL?>assets/css/main.css" rel="stylesheet" type="text/css">
    </head>
    <body>
        <div class="navbar navbar-default">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-ex-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button> 
                    <a class="navbar-brand" href="#">
                        <span>Dominon Decker</span>
                    </a> 
                </div>
                <div class="collapse navbar-collapse" id="navbar-ex-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"> <a href="#">Home</a> </li>
                        <li> <a href="#">About</a> </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="content col-md-12 text-center">
                    <h1 class="text-danger">Dominion Decker</h1>
                    <p class="text-primary">Générateur de deck aléatoire</p>
                    <h3>Selectionne tes extensions :</h3>
                    <div class="btn-group" data-toggle="buttons">
                        <?php
                        $i = 1;
                        foreach ($expansion as $exp) {
                            $name = $exp['expansion'];
                            ?>
                            <label class="btn btn-primary">
                                <input name="expansions" type="checkbox" autocomplete="off" value="<?= $name ?>"><?= $name ?>
                            </label>
                            <?php
                            $i++;
                        }
                        ?>
                    </div>
                    <br>
                    <br>
                    <span id="btn-gen" class="btn btn-lg btn-default" >Generate</span> 
                    <div class="deck"></div>
                </div>
            </div>
        </div>
        <script type='text/javascript'>
            $("#btn-gen").on("click", function () {
                var exp = new Array();
                $('input:checkbox[name=expansions]:checked').each(function ()
                {
                    exp.push($(this).val());
                });
                $.post('<?= BASE_URL ?>decker/',{"expansion": exp}, function (res) {
                    $('.deck').html(res)
                });
            });
        </script>
    </body>
</html>