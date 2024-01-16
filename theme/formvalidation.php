<?php
    // Inside your neo_send_email function
    function neo_send_email() {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data, true);
    
        $name = $data['form_data']['name'];
        $email = $data['form_data']['email'];
        $phone = $data['form_data']['phone'];
        $message = $data['form_data']['message'];
    
        $to = 'lijo@neoito.com';
        $subject = 'New Form Submission';
        $email_body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage: $message";
        $headers = 'From: sender@example.com';

        mail($to, $subject, $email_body, $headers);

        $response = array(
            'status' => 'success',
            'message' =>   $email_body,
        );

        header('Content-Type: application/json');
        echo json_encode($response);
        wp_die();
    }   
?>