import $ from "jquery";
import { fetchAllProjects } from "./projects/index.js";

$(function () {
    fetchAllProjects();
});
// Initial setup
const token = "2|iwlR0NefAp3yL8n1tdRQvdncsKlN8pr8SkzP1v3x8ed69f31";
const csrfToken = $('meta[name="csrf-token"]').attr("content");
