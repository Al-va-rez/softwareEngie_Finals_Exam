<!-- OPERATIONS MESSAGE: green text if it worked; otherwise red -->
<?php if (isset($_SESSION['message']) && isset($_SESSION['status'])) { ?>
    <div class="position_Center">
        <?php
            if ($_SESSION['status'] == "200") {

                echo "<h2 class='center_Form' style='color: green;'>{$_SESSION['message']}</h2>";

            } else {
                echo "<h2 class='center_Form' style='color: red;'>{$_SESSION['message']}</h2>";
            }
            
        ?>
    </div>
<?php } 
    unset($_SESSION['message']);
    unset($_SESSION['status']);
?>
