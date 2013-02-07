<?php
//on regarde si il le formulaire est envoy�
if (!empty($_POST)){
    //si oui on extrait les donn�es
    extract($_POST);
    $valid = true;
  
    //on regarde si le non est vide
    if(empty($nom)){
        //si oui, on d�clare l'erreur
        $valid=false;
        $erreurnom="vous n'avez pas renseigner votre nom";
    }
      
    //on regarde si le champ email est vide
    if(empty($mail)){
        $valid=false;
        $erreuremail="vous n'avez pas renseigner votre email";
    }
    //si le champ email n'est pas vide on regarde si l'email est valide
    else if(!preg_match("/^[a-z0-9\-_.]+@[a-z0-9\-_.]+\.[a-z0-9]{2,3}$/i",$mail)){
        $valid=false;
        $erreuremail="Votre email n'est pas valide";
    }
      
    //on regarde si le champ message est rempli
    if(empty($message)){
        $valid=false;
        $erreurmessage="vous n'avez pas rempli votre message";
    }
       
    //on regarde si il y eu une erreur
    if($valid){
          
        //on regarde si le service selectionn� est dans le tableau
        if(!in_array($service,array("association","mada",))){
            //si pas dans un tableau, on indique le service
            $service="association";
        }
          
        $to = "$service@ezekias.org";
        $sujet = $nom." a envoy une demande via le formulaire du site" ;
        $header = "From: association@ezekias.org \n";
        $header .= "Reply-To: $email";
           
        $message = stripslashes($message);
        $nom = stripslashes($nom);
          
        //on appel la fonciton mail de php
        if (mail($to,$sujet,$message,$header)){
            $erreur = "Votre demande nous ai bien parvenu";
            unset($nom);
            unset($email);
            unset($message);
           
        }
        else
        {
            $erreur = "Une erreur est survenue et votre demande n'a pas aboutit";
        }
    }
}
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Document sans titre</title>
        <script type="text/javascript" language="Javascript" src="jquery.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($){
      
                $("#adresse").hide();
                $("#monform").submit(function(){
                    var valid = true;
                    var name = $("#monform input[name=nom]");
                    var email = $("#monform input[name=email]");
                    var message = $("#monform textarea[name=message]");
          
                    if(name.val()==""){
                        name.css("border-color","#FF0000");
                        name.next(".error-message").text("Veuillez entrer un nom");
                        valid = false;
                    }
                    else{
                        name.css("border-color","#00ff00");
                        name.next(".error-message").text("");
                    }
              
                    if(email.val()==""){
                        email.css("border-color","#FF0000");
                        email.next(".error-message").text("Veuillez entrer un email");
                        valid = false;
                    }
                    else{
                                  
                        if(!email.val().match(/^[a-z0-9\-_.]+@[a-z0-9\-_.]+\.[a-z0-9]{2,3}$/i)){
                            email.css("border-color","#FF0000");
                            email.next(".error-message").text("Veuillez entrer un email valide");
                            valid = false;
                  
                        }
                        else{              
                            email.css("border-color","#00FF00");
                            email.next(".error-message").text("");
                        }
                    }
          
                    if(message.val()==""){
                        message.css("border-color","#FF0000");
                        message.next(".error-message").text("Veuillez entrer un message");
                        valid = false;
                    }
                    else{
                        message.css("border-color","#00FF00");
                        message.next(".error-message").text("");
                    }
                    
                    if(valid) {
                        return true;
                    } else {
                        return false;
                    }
                });
            });
        </script>
        <style type="text/css">
            input{
                border:dotted 1px #7A7A7A;
            }
            textarea{
                border:dotted 1px #7A7A7A;
                width:100%;
                height:150px;
            }
            input[type=submit]{
                background:#DDD;
                cursor:pointer;
            }
            input[type=submit]:over{
                background:#FFF;
            }
            .error-message{
                color:#FF0000;
            }
            #adresse{
                display:none;
            }
        </style>
    </head>
  
    <body>
        <div id="contenu">
            <h1>Formulaire de demande</h1>
            <form method="post" id="monform" action="formulaire.php">
                <label for="nom">Nom :</label>
                <br><input type="text" name="nom" value="">
                <span class="error-message"></span>
  
                <input type="text" name="adresse" id="adresse">
  
                <br><label for="email">Email :</label>
                <br><input type="text" name="email" value="">
                <span class="error-message"></span>
  
  
  
                <br>
                <label for="email">Service � contacter</label>
                <br><select name="service">
                    <option value="association">Si�ge � la R�union</option>
                    <option value="mada">Si�ge � Madagascar</option>
  
                </select>
  
                <br><label for="object">Object de votre demande</label>
                <br><select name="object" id="object">
                    <option value="Choisir" selected>Choisir</option>
                    <option value="demande d'information">Demande d'information</option>
                    <option value="aider l'association">Aider l'association</option>
                    <option value="visiter l'association">Visiter l'association</option>
                </select>
  
  
                <br><label for="message">Votre message :</label>
                <br><textarea name="message"></textarea>
                <span class="error-message"></span>
  
  
                <br><input type="submit" value="Envoyer">
            </form>
        </div>
    </body>
</html>