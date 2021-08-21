window.addEventListener('DOMContentLoaded', () => {
    // Carousel
    const carouselShowcase = document.querySelector('#carouselShowcase')
    const carousel = new bootstrap.Carousel(carouselShowcase, {
        interval: 6000,
        pause: 'hover'
    })

    // Modal video
    const videoBtn = document.querySelector('.video-player__btn')
    const $videoModal = document.getElementById('videoModal')
    const videoFrame = document.querySelector('#videoModal iframe')

    if ($videoModal) {
        const videoModal = new bootstrap.Modal($videoModal, {
            keyboard: true
        })    
    }

    videoBtn.addEventListener('click', e => {
        if (e.currentTarget.classList.contains('video-player__btn')) {
            videoFrame.setAttribute('src', e.currentTarget.dataset.video)
            videoModal.show()                
        }
    })

    $videoModal.addEventListener('hide.bs.modal', function (event) {
        videoFrame.setAttribute('src', '')
    })

    // BaguetteBox
    baguetteBox.run('.gallery__list')
})
