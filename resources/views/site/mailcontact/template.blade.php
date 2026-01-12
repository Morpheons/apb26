<!-- fichier template.html -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="fr">
<head>
    <meta charset="utf-8">
</head>
<body>
<p>
<h1>Message du site Atelier Projet Bois</h1>
Bonjour, <br><br>
Une demande de contact de la part de <b> {{ $data['firstname'] }} {{ $data['name'] }}</b>.<br>
Son numéro de téléphone est le <u>{{ $data['telephone'] }}</u>.<br>
Son email est le suivant : <b>{{ $data['email'] }}</b><br>
Son message est le suivant : <br><br>
<b>Sujet du message :</b> {{ $data['subject'] }}<br><br>
<i>{{ $data['message'] }}</i><br><br>
Rappeler au plus vite.<br><br>
NB : cet utilisateur a accepté que vous lui repondiez
</p>
<p>
    Bonne journée.
</p>
</body>
</html>
