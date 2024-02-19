<?php
if (!isset($_SESSION)) {
    session_start();
}
/**
 * Controlador de la página d
 * @class AllController
 * @brief Controlador de la página 
 */
class AllController
{
    private $View; //objeto de la clase View
    private $Service; //objeto de la clase Service


    /**
     * Constructor de la clase Controller.
     * 
     */
    public function __construct()
    {
        $this->View = new View();
        $this->Service = new Service();
        $this->Service = new Service();
    }

    /**
     * Muestra la página de inicio 
     */
    public function mostrarInicio()
    {


        $this->View->initView(); //muestra la página de inicio 

    }
    /**
     * Pide al servidor el GET de un random 
     */
    public function random()
    {

        $random = json_decode($this->Service->request(), true); //pido al servicio que me de un random, true para que me devuelva un array asociativo
        //var_dump($random);

        $this->View->mostrarCard($random);
    }
    /**
     * pedir al servidor que me mande una lista para cargar un select 
     * 
     */

    public function select()
    {
        $res = $this->Service->requestListSelect(); //$res es un array con la info para cargar un select
        $this->View->showSelect($res); //muestra la vista con el select
        //RECUPERO VALORES POR EL NAME 
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $categoria = $_POST['tipo'];
            //var_dump($categoria);
            //mando l acategoria para que el servicio monte la url
            $res = $this->Service->requestCategory($categoria);
            //var_dump($res);
            $this->View->mostrarCard($res);
        }
    }
    /**
     * Metodo que pide al servidor la info dede un tema seleccionado
     * 
     */
    public function search()
    {
        $this->View->showSearch(); //muestra la vista para que el usuario introduzca el tema

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $search = $_POST['search'];
            //mando l acategoria para que el servicio monte la url
            $res = $this->Service->requestSearch($search);
            //lo guardo en la sesion
            $_SESSION['search_result'] = $res;
            header('Location: index.php?controller=All&action=mostrarCards');
        }
    }

    public function mostrarCards($data = null, $dataIndex = 0, $totalData = 0)
    {
        // Obtener la respuesta de la sesión
        $data = $data ?? (isset($_SESSION['search_result']) ? $_SESSION['search_result'] : null);

        // Recuperar información de la sesión
        $dataIndex = isset($_SESSION['dataIndex']) ? (int)$_SESSION['dataIndex'] : 0;
        $totalData = isset($_SESSION['totalData']) ? (int)$_SESSION['totalData'] : 0;

        // Actualizar índice de datos si se hace clic en Anterior o Siguiente
        if (isset($_POST['accion']) && $_POST['accion'] == 'anterior' && $dataIndex > 0) {
            $dataIndex--;
        } elseif (isset($_POST['accion']) && $_POST['accion'] == 'siguiente' && $dataIndex < $totalData - 1) {
            $dataIndex++;
        }

        // Guardar información en la sesión
        $_SESSION['dataIndex'] = $dataIndex;
        $_SESSION['totalData'] = $totalData;
        $_SESSION['search_result'] = $data;



        // Redirigir a la vista
        $this->View->mostrarCards($data, $dataIndex, $totalData);
    }
}
