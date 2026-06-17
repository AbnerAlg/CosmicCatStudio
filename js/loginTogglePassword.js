function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.querySelector(".toggle-password ion-icon");

    
    if (input.type === "password") {
        input.type = "text";
        icon.setAttribute("name", "eye"); 
    } else {
        input.type = "password";
        icon.setAttribute("name", "eye-off"); 
    }
}
