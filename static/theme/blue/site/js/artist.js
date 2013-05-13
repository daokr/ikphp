function playcount(songid, worked){
    $.get('/j/artist/incplaycount',{song_id:songid,worked:worked?1:0});
}

window.playnext = function(widget_id){
    var just_num = playsong.now_play_song[widget_id], 
        songs = playsong.widgets[widget_id].songs;

    if (just_num >= songs.length - 1){
        playsong(widget_id, 0, true);
    } else {
        playsong(widget_id, just_num + 1);
    }
}

window.playsong = function(widget_id, song_num, hold){
    var mplayer = document.getElementById('mplayer_' + widget_id),
        table = $('.table_' + widget_id);
    $('tr', table).removeClass('selsong');
    $('.tr' + song_num, table).addClass('selsong');

    if(mplayer !== undefined && mplayer.playsong !== undefined){
        var s = playsong.widgets[widget_id].songs[song_num];
        mplayer.playsong(s.url, s.id, hold ? 0 : 1, s.title, s.isdemo);
        playsong.now_play_song[widget_id] = song_num;
    }
}

playsong.widgets = {};
playsong.now_play_song = {};

