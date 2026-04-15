<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="fooldal.css">
    <title>Beadandó - PHP Főoldal</title>
</head>
<body>

<header>
    <h1>Web Beadandó</h1>
    <nav>
        <ul>
            <li><a href="#">Főoldal</a></li>
            <li><a href="#videok">Videók</a></li>
            <li><a href="#terkep">Kapcsolat</a></li>
        </ul>
    </nav>
</header>

<div class="container">
    
    <section class="hero">
        <h5>Üdvözöllek a Főoldalon</h5>
        <p>Valami szöveg.</p>
    </section>

    <section id="videok" class="video-section">
        <h2>Multimédia Tartalom</h2>
        <div class="video-container">
            
            <div style="flex: 1; min-width: 300px;">
                <h3>Saját videó (Helyi)</h3>
                <video width="100%" controls>
                    <source src="sajat_video.mp4" type="video/mp4">
                    A böngésződ nem támogatja a videó lejátszását.
                </video>
            </div>

            <div style="flex: 1; min-width: 300px;">
                <h3>YouTube Videó</h3>
                <iframe width="100%" height="250" src="https://www.youtube.com/embed/dQw4w9WgXcQ" frameborder="0" allowfullscreen></iframe>
            </div>
            
        </div>
    </section>

    <section id="terkep" class="map-section">
        <h2>Fizikai Címünk</h2>
        <p>Itt találsz meg minket:</p>
        <div style="width: 100%">
            <iframe 
                width="100%" 
                height="400" 
                frameborder="0" 
                scrolling="no" 
                marginheight="0" 
                marginwidth="0" 
                src="https://maps.google.com/maps?q=Budapest,Hősök tere&t=&z=15&ie=UTF8&iwloc=&output=embed">
            </iframe>
        </div>
    </section>

</div>

<footer style="text-align: center; padding: 20px; color: #777;">
    <p>&copy; <?php echo date("Y"); ?> - Debreczeni Ákos HWF5W0, Pálami Ádám YB5SIV.</p>
</footer>

</body>
</html>