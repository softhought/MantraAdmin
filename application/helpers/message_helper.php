<?php

function set_flash($name, $message_type, $message, $redirect=FALSE)
{
  $CI =& get_instance();
  $CI->session->set_flashdata($name, array(
    'message_name' =>$name,
    'message_type' => $message_type,
    'message' => $message)
  );
  if ($redirect)
  {
  	redirect($redirect);
  }
    
}
?>