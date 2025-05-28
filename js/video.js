$(document).ready(function () 
{
    $("#mute-video").click(function () 
    {
        const activeSlide = document.querySelector('.swiper-slide-active');
        const videoElement = activeSlide.querySelector('.video-hero');
        if (videoElement) 
        {
            if (videoElement.muted) {
                videoElement.muted = false; // Unmute the video
                $("#volume-off").hide(); // Hide volume-off icon
                $("#volume-on").show(); // Show volume-on icon
            } else {
                videoElement.muted = true; // Mute the video
                $("#volume-on").hide(); // Hide volume-on icon
                $("#volume-off").show(); // Show volume-off icon
            }
        }
    });

    
    // Handle slide change
    swiper.on('slideChange', function () 
    {
        const activeSlide = document.querySelector('.swiper-slide-active');
        activeSlide.style.backgroundColor = 'red';
    });
});

