import $ from "jquery";

export const token = localStorage.getItem("token");
export const csrfToken = $('meta[name="csrf-token"]').attr("content");
