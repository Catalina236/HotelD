<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../imagenes/logo.png">
    <link rel="stylesheet" href="../diseño/style.css">
    <title>Servicios</title>
</head>
<body>
    
    <div class="carrusel">
        <div class="atras">
            <img id="atras" src="../imagenes/atras.png" alt="atras" loading="lazy">
        </div>

        <div class="imagenes">
            <div id="img">
                <img class="img" src="../imagenes/restaurante.jpg" alt="imagen 1" loading="lazy">
            </div>
            <div class="texto" id="texto">
                <h3>Restaurante</h3>
                <p>¡Bienvenido al restaurante Gloria en Oasis! Sumérgete en una experiencia gastronómica excepcional donde la elegancia se encuentra con los sabores exquisitos. Nuestro espacio sofisticado ofrece una variedad de platos cuidadosamente elaborados, desde opciones locales auténticas hasta creaciones culinarias internacionales. Con un servicio atento y un ambiente acogedor, es el lugar perfecto para disfrutar de momentos culinarios inolvidables.</p>
            </div>
        </div>
        <div class="adelante" id="adelante">
            <img src="../imagenes/hacia-adelante.png" alt="adelante" loading="lazy">
        </div>
    </div>
    
    <div class="puntos" id="puntos"></div>
    <script src="../js/app.js"></script>
<style>
/*@import url('https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@500&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Nunito:wght@500&display=swap');
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500&display=swap');

body{
    height: 70vh;
    background-color: rgb(245,245,245);
    font-family: 'Nunito', sans-serif;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding-top: 70px;
}
.atras img{
    width: 34px;
}
.adelante img{
    width: 34px;
}
.atras:hover img{
    cursor: pointer;
}
.adelante:hover img{
    cursor: pointer;
}
.carrusel{
    display: flex;
    align-items: center;    
    justify-content: center;
    overflow: hidden;
    width: 100%;
    height: 60vh;
}
.imagenes{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: end;
}
.img{
    box-shadow: 0px 4px 10px 0px rgba(0,0,0,0.85);
    height: 476px;
    width: 1050px;
    border-radius: 15px;
    margin: 5px;
    object-fit: cover;
    filter: saturate(175%);
}
.texto{
    overflow: hidden;
    position:absolute;
    flex-direction: column;
    transform: translateY(0px);
    margin-bottom: 9px;
    backdrop-filter: blur(20px);
    background-color: rgba(63,106,138,0.21);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 30px;
}
.texto h3{
    text-shadow: 0px 0px 15px black;
    padding-top: 4px;
    color: white;
    font-weight: 300;
    font-size: 27px;
}
.texto p{
    align-items:center;
    padding: 20px;
    color: white;
    font-size: 0px;
    font-weight: 300;
}
.imagenes .texto{
    width: 600px;
    height: 100px;
    transition: 1s;
}
.imagenes:hover .texto{
    transition: height 1s, transform 1s, background-color 1s;
    transform: translateY(-40px);
    height: 410px;
    background-color: rgba(63,106,138,0.71);
}
.imagenes:hover .texto p{
    transition: font-size 0s .2s linear;
    font-size: 23px;
    font-weight: 300;
    text-shadow: 0px 0px 10px #0000;
}
.puntos{
    display: flex;
    margin-top: -64px;
    align-items: center;
    justify-content: center;
}
.puntos p{
    font-size: 100px;
    font-weight:500;
    margin-top: -10px;
    color: black;
}
.puntos .bold{
    font-weight: 600;
    margin-left:3px;
    margin-right:3px;
    color:dodgerblue;
}*/
</style>
</body>
</html>