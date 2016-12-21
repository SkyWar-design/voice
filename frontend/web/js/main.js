$(document).ready(function () {
    $('audio.min').mediaelementplayer({
        audioWidth: 57,
        audioHeight: 57,
        startVolume: 1,
        enableAutosize: false,
        features: ['playpause']
    });
});