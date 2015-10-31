function loginRegister() {
    if (document.getElementsByClassName('login')[0].style.display == "none") {
        document.getElementsByClassName('login')[0].style.display = "block";
        document.getElementsByClassName('register')[0].style.display = "none"
    }
    else {
        document.getElementsByClassName('login')[0].style.display = "none";
        document.getElementsByClassName('register')[0].style.display = "block"
    }
}
