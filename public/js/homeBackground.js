let orientation = 0.5;
let sens = 0;

setInterval(() => {
    if (sens === 0) {
        document.getElementById('myCarousel').style.background = "linear-gradient(" + orientation + "turn, #f8f5f0 ,#8e8c84, white)";
        orientation = orientation + 0.001;
        if (orientation > 0.66) {
            sens = 1;
        }
    }
    if (sens === 1) {
        document.getElementById('myCarousel').style.background = "linear-gradient(" + orientation + "turn, #f8f5f0 ,#8e8c84, white)";
        orientation = orientation - 0.001;
        if (orientation < 0.33) {
            sens = 0;
        }
    }
}, 100);
