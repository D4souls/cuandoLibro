<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./node_modules/atropos/atropos.css" />
    <title>404 Not found</title>
    <link rel="icon" href="../img/logo-alt.png">
</head>

<body class="flex flex-col items-center justify-center w-screen h-screen">
    <!-- main Atropos container (required), add your custom class here -->
    <div class="atropos my-atropos w-[900px] h-1/3 rounded-xl">
        <!-- scale container (required) -->
        <div class="atropos-scale rounded-xl">
            <!-- rotate container (required) -->
            <div class="atropos-rotate rounded-xl">
                <!-- inner container (required) -->
                <div
                    class="atropos-inner bg-white text-white  flex flex-col items-center justify-center gap-2 rounded-md bg-center bg-cover bg-no-repeat drop-shadow-2xl">
                    <h3 class="z-10 text-6xl text-black text-semibold" data-atropos-offset="10">Error 404: Not found
                    </h3>
                    <span class="z-10 text-xl text-black" data-atropos-offset="15">Ups.. parece que no hemos encontrado
                        nada.</span>
                    <span class="z-10 text-lg text-sky-500 mb-8 hover:text-white hover:bg-sky-500 hover:rounded-lg hover:p-2 transition-all ease-in-out" data-atropos-offset="15">
                        <a href="../sites/dashboard.php">Probar de nuevo> </a>
                    </span>
                    <image class="absolute z-0 w-screen"
                        src="https://storage.googleapis.com/gweb-uniblog-publish-prod/original_images/Dino_non-birthday_version.gif"
                        alt="gif_dino">
                </div>
            </div>
        </div>
    </div>
</body>

<script src="./node_modules/atropos/atropos.min.js"></script>
<script>
    const myAtropos = Atropos({
        el: '.my-atropos',
        activeOffset: 40,
        shadowScale: 0.9,
        //   onEnter() {
        //     console.log('Enter');
        //   },
        //   onLeave() {
        //     console.log('Leave');
        //   },
        //   onRotate(x, y) {
        //     console.log('Rotate', x, y);
        //   }
    });
</script>

</html>