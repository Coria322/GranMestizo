@extends('layouts.app')
@section('head')
@vite(['resources/css/components/index.css', 'resources/js/components/components.js'])
@endsection
@section('content')
<div class="main-panel">

    {{-- Nav-bar --}}
    <nav class="nav-bar">
        <!-- Lado Izquierdo: Logo + Nombre -->
        <div class="nav-left">
            <img class="logo-mex-terracota" alt="Logo" src="{{ asset('imgs/Logo Mex terracota.png') }}">
            <div class="logo-text">El Gran Mestizo</div>
        </div>

        <!-- Lado Derecho: Botones -->
        <div class="nav-right">
            <button class="bot-sf" onclick="window.location.href='#nosotros'">Prueba la Tradición</button>
            <button class="bot-sf" onclick="window.location.href='#chefs'">El Talento Mestizo</button>
            <button class="bot-sf" onclick="window.location.href='#historia'">Nuestra Historia</button>
            <button class="bot-sf" onclick="window.location.href='#platillos'">Nuestros Platillos</button>
        </div>
    </nav>

    {{-- BIENVENIDA --}}
    <section class="panel-bienvenida" id="nosotros">
        <div class="contenedor-banner">
            <h1 class="title">Prueba la Tradición de México</h1>
            <div class="span-container">
                <span>
                    <p>
                        En El Gran Mestizo, cada platillo es un homenaje a la riqueza culinaria de México.
                        Rescatamos recetas ancestrales, fusionándolas con técnicas contemporáneas para brindarte una experiencia única.
                        Desde los aromas ahumados del mezcal hasta el sabor profundo del maíz, cada bocado te transportará a las raíces de nuestra tierra.
                    </p>
                    <p>
                        Descubre la pasión, el sabor y la historia en cada detalle. Bienvenido a la alta cocina mexicana.
                    </p>
                </span>
            </div>
            <a href=" {{ route('login')  }} " class="generic-btn">
                <div class="btn-text">Reserva ahora</div>
            </a>
        </div>
    </section>

    {{-- TALENTO (CHEFS) --}}
    <section class="section-talento" id="chefs">

        <h1 class="el-talento-mestizo">El Talento Mestizo</h1>

        {{-- Chef 1 --}}
        <div class="cocinero-cont">
            <div class="contenido-chef">
                <img class="img-talento" alt="Deyanira" src="{{ asset('imgs/Deyanira-img.png') }}">
                <div class="texto-chef">
                    <h2 class="Nombre">Deyanira Navarro Gallegos</h2>
                    <div class="historia-chef">
                        Originaria de Tuitán, Durango, Deyanira se interesó desde muy chiquita en la cocina y cada receta y técnica culinaria que ha aprendido,
                        la conectaron de manera más profunda con sus raíces y su cultura. Su crecimiento culinario no solo se refleja en su habilidad para preparar
                        deliciosos platillos tradicionales, sino también en su pasión por preservar y compartir las recetas y tradiciones culinarias de su región.
                        Ha representado la gastronomía de Durango en varios eventos nacionales y actualmente colabora con diversos restaurantes compartiendo sus
                        conocimientos gastronómicos para mejorar la experiencia de los clientes.
                    </div>
                </div>
            </div>
        </div>

        {{-- Chef 2 --}}
        <div class="cocinero-cont">
            <div class="contenido-chef">
                <img class="img-talento" alt="Xrys" src="{{ asset('imgs/Xrysw-img.png') }}">
                <div class="texto-chef">
                    <h2 class="Nombre">Xrys Ruelas</h2>
                    <div class="historia-chef">
                        Desde que en 2021 llegó a la final de S. Pellegrino Young Chef, realizada en Milán, la carrera de Xrysw Ruelas ha ido en ascenso.
                        Ella es originaria de Guadalajara, Jalisco, y aunque la gastronomía no fue su primera elección vocacional, al decidirse por la cocina
                        lo hizo a lo grande, trabajando para reconocidos restaurantes y como cocinera en un crucero. De vuelta en tierra firme, esta joven y talentosa
                        chef abrió una dulcería, para después inaugurar junto con su pareja, el también chef Óscar Segundo, el restaurante Xokol, en Guadalajara.
                    </div>
                </div>
            </div>
        </div>

        {{-- Chef 3 --}}
        <div class="cocinero-cont">
            <div class="contenido-chef">
                <img class="img-talento" alt="Juana" src="{{ asset('imgs/Juana-img.png') }}">
                <div class="texto-chef">
                    <h2 class="Nombre">Juana Segovia Bonilla</h2>
                    <div class="historia-chef">
                        Es una cocinera originaria de Pocyaxum, Campeche, que desde muy pequeña demostró interés por la cocina, ayudando a su madre a preparar guisos
                        y aprendiendo los secretos de la cocina casera. Con el tiempo, Juana se convirtió en una experta en la cocina tradicional de su región y comenzó
                        a vender tamales y otros platillos, ganándose el reconocimiento de su comunidad y de figuras importantes, como el gobernador de Campeche.
                        Ha participado en exposiciones gastronómicas en varios lugares y ha dado conferencias a estudiantes de gastronomía, dejando una marca en la
                        preservación y promoción de la cocina tradicional de su estado.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- HISTORIA --}}
    <section class="section-historia" id="historia">
        <div class="historia-content">

            <!-- Columna: Imagen -->
            <div class="historia-img-wrapper">
                <img src="{{ asset('imgs/El gran mestizo foto.png') }}" alt="Foto El Gran Mestizo" class="historia-img">
            </div>

            <!-- Columna: Texto -->
            <div class="historia-texto">
                <h2 class="historia-titulo">Nuestra Historia</h2>
                <p>
                    En el corazón de México, donde las culturas se entrelazan y las tradiciones se reinventan, nació El Gran Mestizo.
                    Este restaurante es más que un espacio gastronómico: es un tributo a la fusión de sabores, técnicas y legados que dieron vida a la cocina mexicana.
                </p>
                <p>
                    Inspirados en la riqueza del mestizaje, nuestros artesanos del fogón combinan ingredientes ancestrales con la visión contemporánea de la alta cocina.
                    Aquí, el maíz se encuentra con el fuego, el cacao susurra historias de tiempos prehispánicos y el mezcal brinda con la modernidad.
                    Cada platillo es un puente entre el pasado y el presente, un homenaje a los pueblos originarios y a las influencias que enriquecieron nuestra identidad culinaria.
                </p>
                <p>
                    En El Gran Mestizo, celebramos la diversidad en cada bocado, recordando que la grandeza de México radica en su historia, su gente y su cocina.
                    Bienvenido a un festín de tradición y evolución.
                </p>
            </div>

        </div>
    </section>

    {{-- PLATILLOS --}}
    <section class="section-platillos" id="platillos">
        <h1 class="title-platillos">Sabores que narran nuestra identidad</h1>
        <button class="nav-button prev">&#10094;</button>
        <div class="platillos-container">
            @forelse ($platillos as $platillo)
                <div class="platillo-card">
                    @if($platillo->PLATILLO_IMAGEN)
                        <img src="{{ asset('storage/' . $platillo->PLATILLO_IMAGEN) }}" alt="Imagen de {{ $platillo->PLATILLO_NOMBRE }}">
                    @else
                        <img src="{{ asset('imgs/platillo-1.png') }}" alt="Sin imagen">
                    @endif
                    <div class="platillo-info">
                        <h2>{{ $platillo->PLATILLO_NOMBRE }}</h2>
                        <p>{{ $platillo->PLATILLO_DESCRIPCION }}</p>
                    </div>
                </div>
            @empty
                <p>Visitanos y vive la experiencia secreta.</p>
            @endforelse
        </div>
        <button class="nav-button next">&#10095;</button>
    </section>


</div>
@endsection