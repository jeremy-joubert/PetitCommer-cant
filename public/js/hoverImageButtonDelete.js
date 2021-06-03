document.addEventListener('DOMContentLoaded', function() {
    let images = document.getElementsByClassName('image_hover')
    for(let i in images){
        images[i].addEventListener('mouseover', function () {
            let enfants = images[i].childNodes
            enfants[1].style.display='block'
            enfants[1].style.position='absolute'
            enfants[1].style.marginBottom='-1rem'
        })
        images[i].addEventListener('mouseout', function () {
            console.log('test')
            let enfants = images[i].childNodes
            enfants[1].style.display='none'
        })
    }
})