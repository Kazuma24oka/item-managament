function previewImage() {
    var file = $("#File").get(0).files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function () {
            $("#preview").html("<img src='" + reader.result + "' class='img-thumbnail' style='max-width: 200px;'>");
        }

        reader.readAsDataURL(file);
    }
}