const BORRAR_IMAGEN = 1;
const RESUMEN_BORRAR_IMAGEN = '¿Borrar imagen?';
const DETALLE_BORRAR_IMAGEN = '¿Está seguro de que desea borrar la imagen? Esta imagen se perderá permanentemente.';

const PUBLICAR_IMAGEN = 0;
const RESUMEN_PUBLICAR_IMAGEN = '¿Publicar imagen?';
const DETALLE_PUBLICAR_IMAGEN = '¿Está seguro de que desea publicar la imagen? Esta imagen podrá ser vista por todos los usuarios de DaxGallery.';

const ERROR = 2;
const RESUMEN_ERROR = 'Se ha producido un error.';

function goBack() {
    window.history.back();
}

function goToIndex() {
    location.href = 'index.php?propias=0';
}

function goToIniciarSesion() {
    location.href = 'inicio_sesion.php';
}

function like(imageId) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            document.getElementById("btnLike").value = this.responseText;
        }
    };
    xmlhttp.open("GET", "getlikes.php?image=" + imageId, true);
    xmlhttp.send();

    likes = parseInt(document.getElementById("btnLike").value.split(":")[1].trim()) + 1;
    document.getElementById("btnLike").value = "Likes: " + likes;
}

function dislike(imageId) {
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
            console.log(this.responseText);
            document.getElementById("btnDislike").value = this.responseText;
        }
    };
    xmlhttp.open("GET", "getdislikes.php?image=" + imageId, true);
    xmlhttp.send();

    dislikes = parseInt(document.getElementById("btnDislike").value.split(":")[1].trim()) + 1;
    document.getElementById("btnDislike").value = "Dislikes: " + dislikes;
}

function mostrarMensaje(msg, tipo, btn) {
    var resum = document.getElementById("resumen");
    var deta = document.getElementById("detalle");
    var panelMensaje = document.getElementById("myModal");
    var modalFooter = document.getElementsByClassName("modal-footer")[0];

    var botones = document.getElementsByClassName("boton");

    for (var i = 0; i < 2; i++) {
        botones[i].disabled = true;
    }

    switch (tipo) {
        case PUBLICAR_IMAGEN:
            resum.innerHTML = RESUMEN_PUBLICAR_IMAGEN;
            deta.innerHTML = DETALLE_PUBLICAR_IMAGEN;

            var btnNo = document.createElement('input');
            btnNo.type = "button";
            btnNo.value = "No";
            btnNo.id = "btn_cerrar";
            btnNo.className = "btn";

            //Quedan cosas por hace
            var btnSi = document.createElement('input');
            btnSi.type = "button";
            btnSi.value = "Sí, estoy seguro";
            btnSi.id = "btn_si";
            btnSi.className = "btn btn-primary";


            btnNo.onclick = function () {
                cerrarMensaje();
                /*if (btn != undefined)
                 btn.disabled = false;*/
            };

            btnSi.onclick = function () {
                cerrarMensaje();
                /*if (btn != undefined)
                 btn.disabled = false;*/
                //window.location.assign("borrar_imagen.php" + location.search);
            };

            modalFooter.appendChild(btnNo);
            modalFooter.appendChild(btnSi);
            break;
        case BORRAR_IMAGEN:
            resum.innerHTML = RESUMEN_BORRAR_IMAGEN;
            deta.innerHTML = DETALLE_BORRAR_IMAGEN;

            var btnNo = document.createElement('input');
            btnNo.type = "button";
            btnNo.value = "No";
            btnNo.id = "btn_cerrar";
            btnNo.className = "btn";

            //Quedan cosas por hace
            var btnSi = document.createElement('input');
            btnSi.type = "button";
            btnSi.value = "Sí, estoy seguro";
            btnSi.id = "btn_si";
            btnSi.className = "btn btn-primary";

            btnNo.onclick = function () {
                cerrarMensaje();
                /*if (btn != undefined)
                 btn.disabled = false;*/
            };

            btnSi.onclick = function () {
                cerrarMensaje();
                /*if (btn != undefined)
                 btn.disabled = false;*/
                //window.location.assign("borrar_imagen.php" + location.search);
            };

            modalFooter.appendChild(btnNo);
            modalFooter.appendChild(btnSi);
            break;
        case ERROR:
            deta.innerHTML = msg;
            resum.innerHTML = RESUMEN_ERROR;
            var btnCerrar = document.createElement('input');
            btnCerrar.type = "button";
            btnCerrar.value = "Cerrar";
            btnCerrar.id = "btn_cerrar";
            btnCerrar.onclick = function () {
                cerrarMensaje();
                /*if (btn != undefined)
                 btn.disabled = false;*/
            };

            var btnRecargar = document.createElement('input');
            btnRecargar.type = "button";
            btnRecargar.value = "Recargar";
            btnRecargar.id = "btn_recargar";
            btnRecargar.onclick = location.reload;
            break;
    }

    panelMensaje.style.display = "block";
}

function cerrarMensaje() {
    var panelMensaje = document.getElementsByClassName("modal-footer")[0];
    /*panelMensaje.style.display = "none";*/

    var btnNo = document.getElementById("btn_no");
    if (btnNo != undefined) {
        panelMensaje.removeChild(btnNo);
    }

    var btnSi = document.getElementById("btn_si");
    if (btnSi != undefined) {
        panelMensaje.removeChild(btnSi);
    }

    var btnCerrar = document.getElementById("btn_cerrar");
    if (btnCerrar != undefined) {
        panelMensaje.removeChild(btnCerrar);
    }

    var btnRecargar = document.getElementById("btn_recargar");
    if (btnRecargar != undefined) {
        panelMensaje.removeChild(btnRecargar);
    }

    var botones = document.getElementsByClassName("boton");



    for (var i = 0; i < 2; i++) {
        botones[i].disabled = false;
    }

    var modal = document.getElementById('myModal');
    modal.style.display = 'none';
}



