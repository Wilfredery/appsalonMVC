<?php
    foreach($errores as $key => $error){
        foreach($error as $err) {
            ?>

            <div class="alerta <?php echo $key; ?>">
                <?php
                    echo $err;
                ?>
            </div>
            <?php
        }
    }
?>