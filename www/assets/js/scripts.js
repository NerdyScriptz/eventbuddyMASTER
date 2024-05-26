$(document).ready(function() {
    function loadVideos() {
        $.getJSON('video_data.json', function(data) {
            let videoContainer = $('#video-container');
            videoContainer.empty();
            data.videos.forEach(function(video) {
                let videoCard = `
                    <div class="col-md-4">
                        <div class="video-card">
                            <img src="${video.thumbnail}" class="video-thumbnail" alt="${video.title}">
                            <div class="video-info">
                                <h3>${video.title}</h3>
                                <p>${video.description}</p>
                            </div>
                        </div>
                    </div>
                `;
                videoContainer.append(videoCard);
            });
        });
    }

    loadVideos();
});
