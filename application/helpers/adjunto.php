<?php
    ini_set('memory_limit', '280M');

    $json = file_get_contents("php://input");
 
        $api_key = "WSAA.08071107520015:RFi1esgCqjHFkQG"; //produccion
        $key = base64_encode($api_key);
        
        $ch = curl_init();

        //  curl_setopt($ch, CURLOPT_URL, "https://swtest.aduana.gob.sv/WSWebInterface/REST/encodeAttachedDocuments"); //servidor  pruebas
        curl_setopt($ch, CURLOPT_URL, "https://siduneaworld.aduana.gob.sv/WSWebInterface/REST/encodeAttachedDocuments"); // servidor producccion
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 480);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $api_key);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);

        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Accept: application/json',
                'Content-Type: application/json',

            )
            // 'Authorization: '.  $key
        );

        if (curl_exec($ch) === false) {
            echo 'Curl error: ' . curl_error($ch);
        }

        $errors = curl_error($ch);                                                                                                     
        $result = curl_exec($ch);
        $returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE); 
	    $rsl = json_decode($result);
        curl_close($ch);
      
 
       $doc_scaneado = $rsl->ENCODED_ATTACHED_DOCUMENTS;
	    echo $doc_scaneado;
?>