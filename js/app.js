let imagenes=[
    {
        "url":"../imagenes/restaurante.jpg",
        "nombre":"Restaurante",
        "descripcion":"¡Bienvenido al restaurante Gloria en Oasis! Sumérgete en una experiencia gastronómica excepcional donde la elegancia se encuentra con los sabores exquisitos. Nuestro espacio sofisticado ofrece una variedad de platos cuidadosamente elaborados, desde opciones locales auténticas hasta creaciones culinarias internacionales. Con un servicio atento y un ambiente acogedor, es el lugar perfecto para disfrutar de momentos culinarios inolvidables."
    },
    {
        "url":"../imagenes/bar.jpg",
        "nombre":"Bar",
        "descripcion":"¡Bienvenido al Bar Gloria en Oasis! Disfruta de un ambiente animado, cócteles innovadores y la mejor compañía. Desde cócteles creativos hasta cervezas artesanales, nuestro bar es el lugar perfecto para relajarte y disfrutar de momentos inolvidables. ¡Te esperamos para una experiencia única en el Bar Gloria",
        
    },
    {
        "url":"../imagenes/piscina.jpg",
        "nombre":"Zonas húmedas",
        "descripcion":"¡Te damos la bienvenida al Spa en Oasis! Sumérgete en un oasis de serenidad con nuestra piscina rejuvenecedora. Además, disfruta de experiencias de sauna, baño turco y jacuzzi para relajar cuerpo y mente. Nuestro Spa ofrece momentos de bienestar en un entorno tranquilo y elegante. ¡Descubre el lujo del descanso en Oasis"
    },
];

let atras=document.getElementById('atras');
let adelante=document.getElementById('adelante');
let imagen=document.getElementById('img');
let puntos=document.getElementById('puntos');
let texto=document.getElementById('texto');
let actual=0;

posicionCarrusel();

atras.addEventListener('click', function() {
    actual -= 1;
    if (actual == -1) {
        actual = imagenes.length - 1;
    }
    imagen.innerHTML = `<img class="img" src="${imagenes[actual].url}" alt="logo pagina" loading="lazy"></img>`;
    texto.innerHTML = `
        <h3>${imagenes[actual].nombre}</h3>
        <p>${imagenes[actual].descripcion}</p>
    `;
    posicionCarrusel();
});

adelante.addEventListener('click', function() {
    actual += 1;
    if (actual == imagenes.length) {
        actual = 0;
    }
    imagen.innerHTML = `<img class="img" src="${imagenes[actual].url}" alt="logo pagina" loading="lazy"></img>`;
    texto.innerHTML = `
        <h3>${imagenes[actual].nombre}</h3>
        <p>${imagenes[actual].descripcion}</p>
    `;
    posicionCarrusel();
});

function posicionCarrusel() {
    puntos.innerHTML = ''; // Limpiamos el contenido anterior
    for (var i = 0; i < imagenes.length; i++) {
        if (i == actual) {
            puntos.innerHTML += '<p class="bold">.</p>';
        } else {
            puntos.innerHTML += '<p>.</p>';
        }
    }
}
