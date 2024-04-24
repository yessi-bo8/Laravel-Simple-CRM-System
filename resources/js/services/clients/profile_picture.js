document.addEventListener("DOMContentLoaded", function () {
    var profilePictureInput = document.getElementById("profile_picture");
    if (profilePictureInput) {
        profilePictureInput.addEventListener("change", function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector("img").src = e.target.result;
            };
            reader.readAsDataURL(this.files[0]);
        });
    }
});
