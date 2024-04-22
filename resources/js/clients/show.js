import $ from "jquery";
import { showMessage } from "../message.js";
import { handleError } from "../errors.js";
import { getErrorMessage } from "../message.js";

$(document).ready(function () {
    const token = "2|iwlR0NefAp3yL8n1tdRQvdncsKlN8pr8SkzP1v3x8ed69f31";

    function fetchClientDetails(ClientId) {
        $.ajax({
            url: `/api/v1/clients/${ClientId}`,
            headers: { Authorization: "Bearer " + token },
            method: "GET",
            success: displayClientDetails,
            error: function (xhr, status, error) {
                const response = xhr.responseJSON;
                showMessage("error", getErrorMessage(response));
                handleError;
            },
        });
    }

    function displayClientDetails(response) {
        const client = response.data.attributes;
        const relationships = response.data.relationships;

        let projectTitlesHTML = "";
        if (relationships["project titles"]) {
            const projectTitles = relationships["project titles"];
            projectTitles.forEach((title) => {
                projectTitlesHTML += `<p>${title}</p>`;
            });
        }

        // const profilePictureHTML = client.profile_picture
        //     ? `<img src="${client.profile_picture}" alt="Profile Picture">`
        //     : "";

        const clientDetails = `
  <div class="client-details">
    <div class="details-header">
      <h2>Client Details</h2>
    </div>
    <div class="details-content">
      <p><strong>Title:</strong> ${client.name}</p>
      <p><strong>Company:</strong> ${client.company}</p>
      <p><strong>VAT:</strong> ${client.vat}</p>
      <p><strong>Email:</strong> ${client.email}</p>
      <p><strong>Picture:</strong> <img src="${client.profile_picture}" alt="Profile Picture" class="profile-picture"></p>
      </br>
      </p>
      <hr>
      <h3>Projects:</h3>
      ${projectTitlesHTML}
    </div>
    <div class="details-footer">
      <button id="go-back-to-list">Go Back to List</button>
    </div>
  </div>
`;

        $(".client-details").html(clientDetails).show();
        $(".client-containerr").hide();
        $("h1").text("Client info");

        $("#go-back-to-list").click(function () {
            $(".client-containerr").show();
            $(".client-details").html("").hide();
            $("h1").text("All clients");
        });
    }

    // Function to handle errors
    function handleError(xhr, status, error) {
        console.error(error);
    }

    $.ajax({
        url: "/api/v1/clients",
        headers: { Authorization: "Bearer " + token },
        method: "GET",
        success: displayClients,
        error: function (xhr, status, error) {
            const response = xhr.responseJSON;
            showMessage("error", getErrorMessage(response));
            handleError;
        },
    });

    function displayClients(response) {
        const clients = response.data;
        const clientsList = $(".client-container");

        clients.forEach(function (client) {
            const clientContainer = $("<div class='client-list'></div>");

            const clientLink = $("<a href='#'></a>")
                .text(client.attributes.name)
                .addClass("client-details-link")
                .data("client-id", client.id)
                .appendTo(clientContainer);

            clientsList.append(clientContainer);
        });

        $(".client-details-link").click(function (e) {
            e.preventDefault();
            fetchClientDetails($(this).data("client-id"));
        });
    }

    $(".client-details").hide();
});
