function loginRegister() {
    if (document.getElementsByClassName('login').style.display == "none") {
        document.getElementsByClassName('login').style.display = "block";
        document.getElementsByClassName('register').style.display = "none"
    }
    else {
        document.getElementsByClassName('login').style.display = "none";
        document.getElementsByClassName('register').style.display = "block"
    }
}
