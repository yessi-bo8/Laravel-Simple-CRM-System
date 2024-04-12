import $ from "jquery";

$(document).ready(function () {
    // Handle click event for "Create Client" button
    $(document).on("click", "#createClientButton", function (event) {
        // Prevent the default behavior of the link (e.g., navigating to "#")
        event.preventDefault();

        // Hide the client list div
        $(".client-list").hide();
        $(".client-containerr").hide();
        // Show the form container
        $(".form-container").show();
    });
});
