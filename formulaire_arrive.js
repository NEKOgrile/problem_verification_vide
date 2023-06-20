window.addEventListener("load", function () {
    var canvas = document.getElementById("signatureCanvas");
    var context = canvas.getContext("2d");
    var clearButton = document.getElementById("clearButton");
    var okButton = document.getElementById("ok-button");

    canvas.width = canvas.offsetWidth;
    canvas.height = canvas.offsetHeight;

    var isDrawing = false;
    var lastX = 0;
    var lastY = 0;

    function startDrawing(e) {
        isDrawing = true;
        [lastX, lastY] = [e.offsetX, e.offsetY];
    }

    function draw(e) {
        if (!isDrawing) return;
        context.beginPath();
        context.moveTo(lastX, lastY);
        context.lineTo(e.offsetX, e.offsetY);
        context.stroke();
        [lastX, lastY] = [e.offsetX, e.offsetY];
    }

    function stopDrawing() {
        isDrawing = false;
        saveSignature();
    }

    function clearCanvas() {
        context.clearRect(0, 0, canvas.width, canvas.height);
    }

    function saveSignature() {
        const dataURL = canvas.toDataURL("image/png"); // Récupérer l'image sous forme de base64

        const inputText = document.getElementById("signature_id"); // Attribuer la valeur à votre champ (caché je suppose)
        inputText.value = dataURL;
    }

    // Écouter les changements
    document
        .querySelector("#photo")
        .addEventListener("change", function (event) {
            const file = event.target.files[0];

            const reader = new FileReader();
            reader.onloadend = function () {
                const base64Data = reader.result;
                const inputText = document.getElementById("photo_enfant_id"); // Attribuer la valeur à votre champ (caché je suppose)
                inputText.value = base64Data;

            };
            reader.readAsDataURL(file);
        });

    // Gestionnaires d'événements
    canvas.addEventListener("mousedown", startDrawing);
    canvas.addEventListener("mousemove", draw);
    canvas.addEventListener("mouseup", stopDrawing);
    canvas.addEventListener("mouseout", stopDrawing);
    canvas.addEventListener("touchstart", startDrawing);
    canvas.addEventListener("touchmove", draw);
    canvas.addEventListener("touchend", stopDrawing);
    clearButton.addEventListener("click", clearCanvas);

});