<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/webfont.css">
        <link rel="stylesheet" href="css/adjustment.css">
        <link rel="stylesheet" href="css/home.css">
        <link href="http://allfont.net/allfont.css?fonts=agency-fb-bold" rel="stylesheet" type="text/css" />
        <script src="js/jquery-3.3.1.min.js"></script>
        <title>Home</title>
    </head>
    <body>
        <div id="centralize">
            <img src="img/mouse1.png" alt="mouse" class="img_home" id="mouse_img">
            <img src="img/keyboard1.png" alt="keyboard" class="img_home" id="keyboard_img">
            <img src="img/laptop1.png" alt="laptop" class="img_home" id="laptop_img">
            <img src="img/headset1.png" alt="headset" class="img_home" id="headset_img">
            <h1>Area 51</h1><br>
            <a href="" id="mouse">MOUSE</a><br>
            <a href="" id="keyboard">KEYBOARD</a><br>
            <a href="" id="laptop">LAPTOP</a><br>
            <a href="" id="headset">HEADSET &#38; AUDIO</a>
        </div>
    </body>
    <script>
        $("#mouse").hover(function (e) {
            $("#mouse_img").toggleClass("img_animation");
        });
        $("#keyboard").hover(function (e) {
            $("#keyboard_img").toggleClass("img_animation");
        });
        $("#laptop").hover(function (e) {
            $("#laptop_img").toggleClass("img_animation");
        });
        $("#headset").hover(function (e) {
            $("#headset_img").toggleClass("img_animation");
        });
    </script>
</html>
