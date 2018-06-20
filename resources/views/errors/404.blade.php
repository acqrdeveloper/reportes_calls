<!DOCTYPE html>
<html>
    <head>
        <title>Be right back.</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

        {!!Html::style('css/login.min.css')!!}
    </head>
    <body>
        <div class="row " style="opacity: 0.9;">
            <br>
            <div class="col-md-3"></div>
            <div class="col-md-6 ">
                <div class="col-md-12 " >
                    <center>
                        <img src="{{URL::asset('img/logo.svg')}}" width="50%" height="50%" style="padding-right: 0px">
                    </center>
                </div>
                <div class="col-md-12 card">
                    <center>
                        <div class="col-md-12">
                            <font style="font-size: 100px; color: #00acd6"><b>404</b></font>
                        </div>
                        <div class="col-md-12">
                            <font style="font-size: 15px; color: #00acd6">
                                OOOPS! Página no Encontrada
                                <br>
                                Copyright &copy; {{date('Y')}} <a href="http://www.sapia.com.pe" target="_blank">Sapia</a>. Derechos Reservados.
                                <br><br>
                                <font style="font-size: 13px; text-decoration: underline"><a href="/">Volver al Sistema</font>
                            </font>
                        </div>
                    </center>
                </div>
            </div>
            <div class="col-md-3"></div>
        </div>

        {!!Html::script('js/cosapidata_login.min.js')!!}
        <script>
            $.backstretch([
                "/background/background_01.jpg",
                "/background/background_02.jpg",
                "/background/background_03.jpg",
                "/background/background_04.jpg",
                "/background/background_05.jpg"
            ], {duration: 3000, fade: 750});
        </script>
    </body>
</html>
