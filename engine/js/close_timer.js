function timer() {

    var obj = document.getElementById('timer_inp');
    obj.innerHTML--;

    if (obj.innerHTML == -1) {
        obj.innerHTML = '0';
        var obj = document.getElementById('timer_inp');
        obj.innerHTML--;
        if (obj.innerHTML == -1) {
            obj.innerHTML = '0';
            document.location.href = '/error/closed.php';
            setTimeout(function () {
            }, 1000);
        }
        else {
            document.getElementById('timer_inp').innerHTML = 60;
            timer();
        }
    }
    else {
        setTimeout(timer, 1000);
    }
}
setTimeout(timer, 1000);
