$(document).ready(function () 
{
    $(".icon.password").click(function () 
    {
        const password = $("#password-input");
        // Determine the current type of the password input
        const type = password.attr("type") === "password" ? "text" : "password";
        // Toggle the input type between password and text
        password.attr("type", type);
        // Toggle the icon based on the type
        $(this).attr("src", type === "password" ? "/svg/form/eye_on.svg" : "/svg/form/eye_off.svg");
    });
});
