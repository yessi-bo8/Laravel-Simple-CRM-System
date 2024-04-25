import $ from "jquery";
import { showMessage } from "../../components/message.js";
import { token } from "../../config/config.js";
import { handleError } from "../../utils/errors.js";
import { getErrorMessage } from "../../components/message.js";

$(document).ready(function () {
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
                <p><strong>Picture:</strong> 
                ${
                    client.profile_picture
                        ? `<img src="${client.profile_picture}" alt="Profile Picture" class="profile-picture">`
                        : "No current profile picture"
                }
                </p>
                </br>
                
                <hr>
                <h3>Projects:</h3>
                ${projectTitlesHTML ? projectTitlesHTML : "No current projects"}
            </div>
            <div class="details-footer">
                <button id="go-back-to-list">Go Back to List</button>
            </div>
        </div>
        `;

        $(".client-details").html(clientDetails).show();
        $(".client-container").hide();
        $("h1").text("Client info");

        $("#go-back-to-list").click(function () {
            $(".client-container").show();
            $(".client-details").html("").hide();
            $("h1").text("All clients");
        });
    }

    const currentUrl = window.location.pathname;
    if (currentUrl === "/clients") {
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
    }

    function displayClients(response) {
        $(".client-details-link").click(function (e) {
            e.preventDefault();
            fetchClientDetails($(this).data("client-id"));
        });
    }

    $(".client-details").hide();
});
