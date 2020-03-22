function darker() {
     if (sessionStorage.getItem('bg') == 'url("/styles/bckg-light.jpg")') {
            sessionStorage.setItem('bg', 'url("/styles/bckg-dark.jpg")');
     }
    else if (sessionStorage.getItem('bg') == null || undefined) {
        sessionStorage.setItem('bg', 'url("/styles/bckg-light.jpg")');
    }
    else if( sessionStorage.getItem('bg') == 'url("/styles/bckg-dark.jpg")') {
        sessionStorage.setItem('bg', 'url("/styles/bckg-light.jpg")');
    }
document.body.style.backgroundImage = sessionStorage.getItem('bg');
}