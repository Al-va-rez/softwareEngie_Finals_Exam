<!-- RESPONSE MESSAGE -->

<!-- check first if message and status are ready -->
<?php if (isset($_SESSION['message']) && isset($_SESSION['status'])) { ?>

    <!-- encolsed in div for design -->
    <div class="main">
        <?php
            if ($_SESSION['status'] == "200") {

                // green text if it worked
                echo "<h2 class='center_Form' style='color: green;'>{$_SESSION['message']}</h2>";

            } else {
                // otherwise red
                echo "<h2 class='center_Form' style='color: red;'>{$_SESSION['message']}</h2>";
            }
            
        ?>
    </div>
    
<?php } 
    unset($_SESSION['message']);
    unset($_SESSION['status']);
?>
