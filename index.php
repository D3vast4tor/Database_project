<!DOCTYPE html>
<html>
<head>
    <link rel='stylesheet' href="style.css">
    <script src="./rsc/particles.js"></script>
    <script>
        window.onload = function() {
        Particles.init({
        selector: '.background',
        maxParticles: 400,
        color: ['#FFFF00','#79bf22'],
        connectParticles: true
    });
        };
    </script>
</head>
<body>
    <div class="logo">
        <img src="./img/logo.png">
    </div>
  <canvas class="background"></canvas>
    
</body>
</html>