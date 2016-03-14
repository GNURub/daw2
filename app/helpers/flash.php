<?php
if( !session_id() )
{
    session_start();
}

function flash( $name = '', $message = '', $label = '', $type='' )
{
    //We can only do something if the name isn't empty
    if( !empty( $name ) )
    {
        //No message, create it
        if( !empty( $message ) && empty( $_SESSION[$name] ) )
        {
            if( !empty( $_SESSION[$name] ) )
            {
                unset( $_SESSION[$name] );
            }

            $_SESSION[$name] = array($message, $label, $type);
        }
        //Message exists, display it
        elseif( !empty( $_SESSION[$name] ) && empty( $message ) )
        {
            echo "<x-notify msg='{$_SESSION[$name][0]}' label='{$_SESSION[$name][1]}' type='{$_SESSION[$name][2]}'></x-notify>";
            unset($_SESSION[$name]);
        }
    }
}

 ?>
