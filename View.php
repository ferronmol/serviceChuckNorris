<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
/**
 *  Clase View para la aplicación de Chuck Norris.
 **/
class View
{

    /**
     * Muestra la página de inicio.
     * 
     */
    public function initView()
    {
?>
        <div class="main-container__content">

            <div class="main-container__content__title">
                <h1 class="animate-character">APP Chuck Norris</h1>
            </div>
            <div class="main-container__content__subtitle">
                <h2 class="text txt-white">Hit with a punch</h2>
            </div>
        </div>

    <?php
        // Llamada al segundo método
        $this->showInfo();
    }

    /**
     * Muestra la información principal de la aplicación mediante botones.
     */
    public function showInfo()
    {
    ?>
        <div class="main-container__flight">
            <div class="main-container__flight-title">
                <h1 class="black-text">Chuck Options</h1>
            </div>
            <div class="main-container__content__btn">
                <a href="index.php?controller=All&action=random" class="btn-flight">Random Joke</a>
                <a href="index.php?controller=All&action=select" class="btn-flight">Select Joke</a>
                <a href="index.php?controller=All&action=search" class="btn-flight">Search Joke</a>
            </div>
        </div>
    <?php
    }

    /**
     * Método para mostrar VALORES DE UN ARRAY ASOCIATIVO
     * @param array $cards Array con la información de las cards.
     */

    public function mostrarCard($card)
    {

    ?>
        <div class="fluid-container">
            <p class="black-text center">Random Joke</p>
            <p class='whitexl'>
                <?= $card['value'] ?>
            </p>
        </div>
        <a href="index.php?controller=All&action=mostrarInicio" class="btn btn-primary">Back</a>
    <?php
    }
    public function showSelect($res)
    {
        /**
         * Metodo que muestra el formulario para seleccionar una categoria
         * @param $res array con la info para cargar el select
         * @return post con la categoria seleccionada
         */
    ?>
        <h5 class="animate-character mt-5">select</h5>
        <div class="form-container">
            <form class="form center" action="index.php?controller=all&action=select" method="post">
                <!-- <div class="form-group">
                    <label for=" identificador">Identificador</label>
                    <input type="text" name="identificador" class="form-control" id="identificador" placeholder="" value="">
                </div> -->
                <div class="form-group">
                    <label for="tipo">Tipo</label>
                    <select name="tipo" class="form-select" id="tipo">
                        //hago un foreach para recorrer el array y mostrar los valores en el select
                        <?php
                        // foreach ($res as $key => $value) { si quiero que el value sea el indice
                        foreach ($res as $value) {  //si quiero que el value sea el valor
                            echo '<option value="' . $value . '">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <!-- <a href="index.php?controller=All&action=mostrarInicio" class="btn btn-primary">Back</a> -->
        </div>
    <?php
    }
    /**
     * Metodo que muestra el formulario para que pueda buscar por tema
     * 
     */
    public function showSearch()
    {
    ?>
        <h5 class="animate-character mt-5">Search</h5>
        <div class="form-container">
            <form class="form" action="index.php?controller=all&action=search" method="post">
                <div class="form-group">
                    <label for="tipo">Busqueda</label>
                    <input required type="search" name="search" class="">
                </div>
                <button type="submit" class="btn btn-primary mt-2">Submit</button>
            </form>
            <a href="index.php?controller=All&action=mostrarInicio" class="btn btn-primary">Back</a>
        </div>
    <?php
    }
    /**
     * Metodo que muestra las cards
     * @param array $data array con dos props, total y results, dentro de results hay un array con la info de cada card
     * 
     */
    public function mostrarCards($data, $dataIndex, $totalData)
    {
    ?>
        <div class="container mt-4 ml-12">
            <div class="rowleft row">

                <?php if (isset($data['total']) && isset($data['result']) && is_array($data['result'])) :
                    $results = $data['result'];
                    $totalData = $data['total'];

                    if (!empty($totalData) && !empty($results)) :
                        foreach ($results as $index => $result) :
                ?>
                            <div class="col-md-6 mb-6 center" style="display: <?= ($dataIndex == $index ? 'block' : 'none') ?>">
                                <div class="card cardm">
                                    <div class="card-body">
                                        <h5 class="card-title whitexl"><?= $result['value'] ?></h5>
                                    </div> <!-- Fin card-body -->
                                </div> <!-- Fin card -->
                            </div> <!-- Fin col-md-6 -->
                        <?php endforeach; ?>

                        <!-- Actualizo las variables de sesión -->
                        <?php $_SESSION['dataIndex'] = $dataIndex; ?>
                        <?php $_SESSION['totalData'] = $totalData; ?>

                        <!-- Botones para paginar -->
                        <div class="buttons-container mt-3 d-flex justify-content-around">
                            <?php if ($dataIndex > 0) : ?>
                                <form method="post" action="index.php?controller=All&action=mostrarCards">
                                    <input type="hidden" name="dataIndex" value="<?= ($dataIndex - 1) ?>">
                                    <input type="hidden" name="totalData" value="<?= $totalData ?>">
                                    <button type="submit" name="accion" value="anterior" class="btn btn-primary">Anterior</button>
                                </form>
                            <?php endif; ?>

                            <?php if ($dataIndex < $totalData - 1) : ?>
                                <form method="post" action="index.php?controller=All&action=mostrarCards">
                                    <input type="hidden" name="dataIndex" value="<?= ($dataIndex + 1) ?>">
                                    <input type="hidden" name="totalData" value="<?= $totalData ?>">
                                    <button type="submit" name="accion" value="siguiente" class="btn btn-primary">Siguiente</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php else : ?>
                        <div class="col-md-12">
                            <div class="alert alert-warning" role="alert">
                                No se han encontrado resultados
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else : ?>
                    <div class="col-md-12">
                        <div class="alert alert-danger" role="alert">
                            Ha ocurrido un error al cargar los datos
                        </div>
                    </div>
                <?php endif; ?>
            </div> <!-- Fin row -->
            <a href="index.php?controller=All&action=mostrarInicio" class="btn btn-primary">Back</a>
        </div> <!-- Fin container -->
<?php
    }
}
