$(document).ready(function() {
    $("#mute-video").click(function() {
        const activeSlide = document.querySelector('.swiper-slide-active');
        const videoElement = activeSlide.querySelector('.video-hero');
        if (videoElement) {
            if (videoElement.muted) {
                videoElement.muted = false;
                $("#volume-off").addClass('hidden');
                $("#volume-on").removeClass('hidden');
            } else {
                videoElement.muted = true;
                $("#volume-on").addClass('hidden');
                $("#volume-off").removeClass('hidden');
            }
        }
    });
});