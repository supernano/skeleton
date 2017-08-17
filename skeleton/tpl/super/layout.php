<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ projectName }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>

<body>

<div class="container">

    <div class="jumbotron">
        <h1><a href="/">{{ projectName }}</a></h1>
        <p class="lead"></p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">Awesome!</a></p>
    </div>

    <div class="content">
        <?php include $this->templateFile ?>
    </div>

    <hr>

    <footer class="container">
        <p>&copy; {{ projectName }} <?=date('Y')?></p>
    </footer>

</div>

</body>

</html>
