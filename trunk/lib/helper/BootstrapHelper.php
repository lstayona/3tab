<?php

function bootstrap_stateful_form_control($name, $label, $control_tag_html, $containers = null)
{
    $default_containers = array("error" => array(), "warning" => array(), "success" => array());
    if (!is_array($containers)) 
    {
        $containers = array();
    }

    $containers = array_merge($default_containers, $containers);

    $class = null;

    $message_container = null;
    foreach ($containers as $key => $container)
    {
        if (isset($container[$name])) 
        {
            $message_container = $container[$name];
            $class = " " . $key;
            break;
        }
    }
    ob_start();
?>
<div class="clearfix control-group<?php echo $class; ?>">
    <label for="<?php echo $name;?>"><?php echo $label; ?></label>
    <div class="input">
        <?php echo $control_tag_html; ?>
    <?php 
    if (!is_null($message_container))
    {
        ?>
        <span class="help-inline">
        <?php
        if (is_array($message_container))
        {
        ?>
            <ul>
        <?php
            foreach($message_container as $message)
            {
        ?>
                <li><?php echo $message; ?></li>
        <?php
            }
        ?>
            </ul>
        <?php
        }
        else
        {
            echo $message_container;
        }
        ?>
        </span>
    <?php
    }
    ?>
    </div>
</div>
<?php
    return ob_get_clean();
}
