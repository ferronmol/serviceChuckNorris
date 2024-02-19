<?php
class Service
{
    /******************  G E T *************************************
     * Metodo que pide al servidor la información que tine en la base de datos
     * 
     */

    public function request()
    {
        $urlmiservicio = "https://api.chucknorris.io/jokes/random";
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta, espera un array
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        // Verificar errores
        if ($res === false) {
            echo "Error en la solicitud: " . curl_error($conexion);
            return false;
        }

        // Verificar el código de estado HTTP
        $httpCode = curl_getinfo($conexion, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            echo "Error en la respuesta del servidor (código $httpCode)";
            return false;
        }

        // Cerrar la conexión
        curl_close($conexion);

        // Devolver la respuesta que es un JSON
        return $res;
    }

    /******************  G E T *************************************
     * Metodo que pide al servidor la info para cargar un select
     * @return Array  con la info para cargar un select
     */
    public function requestListSelect()
    {
        $urlmiservicio = "https://api.chucknorris.io/jokes/categories";
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res) {
            // return $res sin el true  si queiro un objeto
            $resArray =  json_decode($res, true);
            curl_close($conexion);
            return $resArray;
        }
    }
    /******************  G E T *************************************
     * Metodo que pide al servidor la info de una categoria
     * @param $categoria categoria de la que se quiere la info
     * @return Array con la info de la categoria
     */
    public function requestCategory($categoria)
    {
        //var_dump($categoria);
        $urlmiservicio = "https://api.chucknorris.io/jokes/random?category=" . $categoria;
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true); //
        $res = curl_exec($conexion);
        if ($res) {
            // return $res SIN TRUE  si queiro un objeto
            $resArray =  json_decode($res, true);
            curl_close($conexion);
            return $resArray;
        }
    }

    /**
     * Metodo que pide al servidor la info dede un tema seleccionado
     * @param $search tema que se quiere buscar
     * @return 
     */
    public function requestSearch($search)
    {
        //var_dump($search); //OK
        $urlmiservicio = "https://api.chucknorris.io/jokes/search?query=" . $search;
        $conexion = curl_init();
        //Url de la petición
        curl_setopt($conexion, CURLOPT_URL, $urlmiservicio);
        //Tipo de petición
        curl_setopt($conexion, CURLOPT_HTTPGET, TRUE);
        //Tipo de contenido de la respuesta
        curl_setopt($conexion, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
        //para recibir una respuesta
        curl_setopt($conexion, CURLOPT_RETURNTRANSFER, true);
        $res = curl_exec($conexion);
        if ($res) {
            // return $res sin el true  si queiro un objeto
            $res =  json_decode($res, true);
            curl_close($conexion);
            return $res;
        }
    }
}
