<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bem Vindo</title>
    <link rel="styles" href="../../favicon.ico">

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />

    <!-- dataPiker -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!-- dataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.7/css/jquery.dataTables.css">
    <script src="https:////cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

    <script>
        $(function () {
            $("#data").datepicker({
                format: "dd/mm/yyyy",
                language: "pt-BR",
                showButtonPanel: true
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            var dataSet = <?php if(isset($medidas)){ 
                                    echo "[";
                                    for($i = 1; $i < count($medidas); $i++) {
                                        echo "[";
                                        for($j = 0; $j < count($medidas[$i]); $j++) {
                                            if ( $j == 0 ) {
                                                echo "'" . substr(mb_substr($medidas[$i][$j], stripos($medidas[$i][$j],":")+1), 0, 11) . "',";
                                            }
                                            else {
                                                if ($j < count($medidas[2])-2) {
                                                    echo "'" . trim(mb_substr($medidas[$i][$j], stripos($medidas[$i][$j],":")+1)) . "',";
                                                }
                                                else {
                                                    if ($j < count($medidas[2])-1) {
                                                        echo "'" . trim(mb_substr($medidas[$i][$j], stripos($medidas[$i][$j],":")+1)) . "'";
                                                    }
                                                }
                                            }
                                        }
                                        if ($i < count($medidas)-1) {
                                            echo "],";
                                        }
                                        else {
                                            echo "]";
                                        }
                                    }
                                    echo "]";
                                }
                                else{ echo "[]";}?>;
            
            $('#parametro').dataTable( {
                "data": dataSet,
                "columns": [
                    { "title": "data" },
                    { "title": "temperatura" },
                    { "title": "ph" },
                    { "title": "dureza" },
                    { "title": "alcalinidade" },
                    { "title": "nivelo2" },
                    { "title": "transparencia" }
                ],
                
                "oLanguage": {
                    "sProcessing": "Aguarde enquanto os dados são carregados ...",
                    "sLengthMenu": "Mostrar _MENU_ registros por pagina",
                    "sZeroRecords": "Nenhum registro correspondente ao criterio encontrado",
                    "sInfoEmtpy": "Exibindo 0 a 0 de 0 registros",
                    "sInfo": "Exibindo de _START_ a _END_ de _TOTAL_ registros",
                    "sInfoFiltered": "",
                    "sSearch": "Procurar",
                    "oPaginate": {
                        "sFirst":    "Primeiro",
                        "sPrevious": "Anterior",
                        "sNext":     "Próximo",
                        "sLast":     "Último"
                    }
                }
            } );
        } );	
    </script>

    <script>
        function consulta() {
            $.ajax({
                type: "POST",
                url: "/",
                dataType: "html",
                success: function(){
                    location.reload();
                }
            })
        }
    </script>
</head>

<body>
    <div class="container">

        <div class="row">
            <form role="form" action="<?php echo base_url("index.php/home/registrar")?>" method="post">
                <div class="row">
                    <div class="col-md-8">
                        <h2>Registre Seu Email <small>Receba notificações</small></h2>
                        <hr class="colorgraph">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address" tabindex="4" required>
                        <br/>
                        <br/>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" value="Registrar Email" class="btn btn-primary btn-block btn-lg" tabindex="7">
                    </div>
                    <div class="col-md-2">
                        <?php
                            if(!empty($this->session->flashdata('message'))){
                                if ($this->session->flashdata('error')) {
                                    echo "<div class=\"alert alert-danger role=\"alert\">" . $this->session->flashdata('message') . "</div>";
                                }
                                else {
                                    echo "<div class=\"alert alert-success role=\"alert\">" . $this->session->flashdata('message') . "</div>";
                                }
                            }
                        ?>
                    </div>
                    <div class="col-md-8">
                        <hr class="colorgraph">
                    </div>

                </div>
            </form>
        </div>

        <div class="row">
            <form role="form" name="consulta" id="consulta" action="<?php echo base_url("index.php/home/consulta") ?>" method="POST">
                <div class="row">
                    <h2 class="col-md-8">Consultar valores</h2>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group date">
                            <input type="text" name="data" id="data" class="form-control input-lg" placeholder="Escolha uma data" tabindex="3" required>
                            <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <input type="submit" class="btn btn-success btn-block btn-lg" value="Consultar">
                    </div>
                </div>
            </form>
        </div>
        <br/>
        <br/>
        <br/>
        <div class=row>
            <table id="parametro" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Temperatura(°C)</th>
                        <th>ph</th>
                        <th>dureza(mg)</th>
                        <th>alcalinidade(mg)</th>
                        <th>nivelo2</th>
                        <th>trasnparência(cm)</th>
                    </tr>
                </thead>

                <tfoot>
                    <tr>
                        <th>Data</th>
                        <th>Temperatura(°C)</th>
                        <th>ph</th>
                        <th>dureza</th>
                        <th>alcalinidade(mg)</th>
                        <th>nivelo2</th>
                        <th>trasnparência(cm)</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>



    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</body>

</html>