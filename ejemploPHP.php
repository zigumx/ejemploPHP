<?php
    $_POST = json_decode(file_get_contents('php://input'), true);

    // $tokenURL = "https://api.zigu.mx/payment/token_service.cfm";
    // $paymentURL = "https://api.zigu.mx/payment/pmt_service.cfm";

    $tokenURL = "https://gateway2.zigu.mx/rest/v1/4.1/token";
    $paymentURL = "https://gateway2.zigu.mx/rest/v1/4.1";

    function sendPost($params, $url) {

        $params["request_response_format"] = "JSON";
        $params["request_api_version"] = "4.4";
        $params["request_currency"] = "MXN";

        $params["req_username"] = ""; // usuario
        $params["req_password"] = ""; // contraseña
        $params["site_id"] = ""; // site id
        $params["merch_acct_id"] = ""; // merchant id
        $params["li_prod_id_1"] = ""; // product id

        //url-ify the data for the POST
        $fields_string = http_build_query($params);

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

        //So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 

        //execute post
        $result = curl_exec($ch);
        // $this->log->warning($result);
        // $jsonResult = json_decode($result, true);
        // return $jsonResult;
        return $result;
    }

    // print_r($_POST);
    if (isset($_POST["value"])) {
        // print_r($_POST["value"]);

        $nombre = $_POST["value"]["nombre"];
        $apellido = $_POST["value"]["apellido"];
        $correo = $_POST["value"]["correo"];

        $valor = $_POST["value"]["valor"];
        $cantidad = $_POST["value"]["cantidad"];

        $calle = $_POST["value"]["calle"];
        $ciudad = $_POST["value"]["ciudad"];
        $estado = $_POST["value"]["estado"];
        $codigoPostal = $_POST["value"]["codigoPostal"];
        $pais = $_POST["value"]["pais"];

        $token = $_POST["value"]["token"];
        $fecha = $_POST["value"]["fecha"];
        $cvv = $_POST["value"]["cvv"];

        $params = [];
        $params["li_count_1"] = "1";
        $params["request_action"] = "CCAUTHCAP";

        $params["li_value_1"] = $valor;

        $params["TOKEN_GUID"] = $token;
        $params["PMT_EXPIRY"] = $fecha;
        $params["PMT_KEY"] = $cvv;

        $params["bill_addr"] = $calle;
        $params["bill_addr_city"] = $ciudad;
        $params["bill_addr_state"] = $estado;
        $params["bill_addr_zip"] = $codigoPostal;
        $params["bill_addr_country"] = "mx";

        $result = sendPost($params, $paymentURL);
        // $jsonResult = json_decode($result, true);
        // print_r($jsonResult);
        die($result);
    }
?>
<!doctype html>
<html lang="en">
    <header>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-wEmeIV1mKuiNpC+IOBjI7aAzPcEZeedi5yW5f2yOq55WWLwNGmvvx4Um1vskeMj0" crossorigin="anonymous">

        <title>Zigu Payments</title>
    </header>
    <body>
        <div class="container">
            <div class="col-6">
                <form>
                    <!-- Cliente -->
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="nameInput" class="form-label">Nombre</label>
                                <input type="nombre" class="form-control" id="nameInput" aria-describedby="emailHelp">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="apellidoInput" class="form-label">Apellido</label>
                                <input type="apellido" class="form-control" id="apellidoInput">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="correoInput" class="form-label">Correo</label>
                                <input type="correo" class="form-control" id="correoInput">
                            </div>
                        </div>
                    </div>
                    <!-- Producto -->
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="valorInput" class="form-label">Valor</label>
                                <input type="valor" class="form-control" id="valorInput">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="cantidadInput" class="form-label">Cantidad</label>
                                <input type="cantidad" class="form-control" id="cantidadInput">
                            </div>
                        </div>
                    </div>
                    <!-- Billing -->
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="calleInput" class="form-label">Calle</label>
                                <input type="callle" class="form-control" id="calleInput">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="ciudadInput" class="form-label">Ciudad</label>
                                <input type="ciudad" class="form-control" id="ciudadInput">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="estadoInput" class="form-label">Estado</label>
                                <input type="estado" class="form-control" id="estadoInput">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="codigoPostalInput" class="form-label">Código Postal</label>
                                <input type="codigoPostal" class="form-control" id="codigoPostalInput">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="paisInput" class="form-label">Pais</label>
                                <input type="pais" class="form-control" id="paisInput">
                            </div>
                        </div>
                    </div>
                    <!-- Tarjeta -->
                    <div class="row">
                        <div class="col">
                            <div class="mb-3">
                                <label for="numeroInput" class="form-label">Número</label>
                                <input type="numero" class="form-control" id="numeroInput">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="fechaInput" class="form-label">Fecha Expiración</label>
                                <input type="fecha" class="form-control" id="fechaInput">
                            </div>
                        </div>
                        <div class="col">
                            <div class="mb-3">
                                <label for="cvvInput" class="form-label">CVV</label>
                                <input type="cvv" class="form-control" id="cvvInput">
                            </div>
                        </div>
                    </div>
                    
                    <button onclick="cobrar(event)" type="submit" class="btn btn-primary">Cobrar</button>
                </form>
            </div>
        </div>
        <script>
            const createToken = async (card_pan) => {
                try {
                    const params = new URLSearchParams()

                    params.append('card_pan', card_pan)
                    params.append('REQUEST_RES', 'JSON')

                    const config = {
                        method          : 'POST',
                        redirect        : 'follow', 
                        referrerPolicy  : 'no-referrer',
                        cache           : 'no-cache',
                        body            : params
                    }

                    return (await fetch(`<?php echo $tokenURL; ?>`, config)).json()
                } catch (error) {
                    throw new Error(error.message)
                }
            }
        </script>
        <script>
            async function cobrar (event) {
                event.preventDefault()
                console.log("cobrar")
                var nombre = document.getElementById("nameInput").value
                var apellido = document.getElementById("apellidoInput").value
                var correo = document.getElementById("correoInput").value
                var valor = document.getElementById("valorInput").value
                var cantidad = document.getElementById("cantidadInput").value
                var calle = document.getElementById("calleInput").value
                var ciudad = document.getElementById("ciudadInput").value
                var estado = document.getElementById("estadoInput").value
                var codigoPostal = document.getElementById("codigoPostalInput").value
                var pais = document.getElementById("paisInput").value
                var numero = document.getElementById("numeroInput").value
                var fecha = document.getElementById("fechaInput").value
                var cvv = document.getElementById("cvvInput").value
                var tokenFull = await createToken(numero)
                var token = tokenFull?.TOKEN_GUID

                var value = {
                    nombre,
                    apellido,
                    correo,

                    valor,
                    cantidad,

                    calle,
                    ciudad,
                    estado,
                    codigoPostal,
                    pais,

                    token,
                    fecha,
                    cvv
                }
                var xhr = new XMLHttpRequest()
                xhr.open("POST", "", true)
                xhr.setRequestHeader('Content-Type', 'application/json')
                xhr.send(JSON.stringify({
                    value
                }))
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var jsonResponse = JSON.parse(this.responseText)
                        console.log(jsonResponse)
                    }
                }
            }
        </script>
        

        <!-- Scripts -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-p34f1UUtsS3wqzfto5wAAmdvj+osOnFyQFpp4Ua3gs/ZVWx6oOypYoCJhGGScy+8" crossorigin="anonymous"></script>
    </body>
</html>