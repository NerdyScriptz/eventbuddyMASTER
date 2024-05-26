$(document).ready(function() {
    function sanitizeInput(input) {
        return DOMPurify.sanitize(input);
    }

    function loadVideos() {
        $.getJSON('video_data.json', function(data) {
            let videoContainer = $('#video-container');
            videoContainer.empty();
            data.videos.forEach(function(video) {
                let sanitizedThumbnail = sanitizeInput(video.thumbnail);
                let sanitizedTitle = sanitizeInput(video.title);
                let sanitizedDescription = sanitizeInput(video.description);

                let videoCard = `
                    <div class="col-md-4">
                        <div class="video-card">
                            <img src="${sanitizedThumbnail}" class="video-thumbnail" alt="${sanitizedTitle}">
                            <div class="video-info">
                                <h3>${sanitizedTitle}</h3>
                                <p>${sanitizedDescription}</p>
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
