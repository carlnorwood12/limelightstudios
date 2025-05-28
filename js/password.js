$(document).ready(function () 
{
    $(".icon.password").click(function () 
    {
        const password = $("#password-input");
        const type = password.attr("type") === "password" ? "text" : "password";
        password.attr("type", type);
        $(this).attr("src", type === "password" ? "/svg/form/eye_on.svg" : "/svg/form/eye_off.svg");
    });
});
