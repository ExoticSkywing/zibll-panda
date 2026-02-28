//头像框
$(function () {
    // 定义一个函数来添加头像框，同时检查是否已经添加
    function addAvatarFrame($element, imgSrc, additionalStyles) {
        if (!$element.find('.txgj').length) { // 检查是否已添加头像框
            let style = additionalStyles ? 'style="' + additionalStyles + '"' : '';
            $element.prepend('<img src="' + imgSrc + '" class="txgj" ' + style + '>');
        }
    }

    const imgSrc = '/wp-content/themes/panda/assets/others/snowy/img/tx.png';

    // 对不同的选择器分别调用函数
    addAvatarFrame($('.avatar-img'), imgSrc);
    addAvatarFrame($('.navbar-avatar'), imgSrc, 'width: 30px;');
    addAvatarFrame($('.avatar-mini'), imgSrc);
    addAvatarFrame($('.comt-avatar'), imgSrc, 'height: 60px;width: 60px;top: 30px;');

    // 设置 z-index 属性
    $('.avatar-set-link').css('z-index', '1');
});

// 下雪
$(document).ready(function(){
    $(document).snowfall({
        flakeCount : 75,
        minSize : 5,
        maxSize : 10,
        minSpeed : 1,
        maxSpeed : 5,
        round : true,
        shadow : false
    });
});

// 音乐播放器
console.clear();

class MusicPlayer {
    constructor(audioSrc) {
        this.audio = new Audio(audioSrc);
        this.playBtn = document.getElementById('play');
        this.playBtn.addEventListener('click', this.togglePlay.bind(this));
        this.controlPanel = document.getElementById('control-panel');
        this.infoBar = document.getElementById('info');
        this.progressBar = this.infoBar.querySelector('.progress-bar');
        this.bar = this.progressBar.querySelector('.bar');
        this.currentTimeSpan = this.progressBar.querySelector('.current-time');
        this.durationSpan = this.progressBar.querySelector('.duration');
        this.audio.addEventListener('ended', this.handleSongEnd.bind(this));
        this.audio.addEventListener('timeupdate', this.updateProgress.bind(this));
        this.progressBar.addEventListener('click', this.seek.bind(this));
        this.isLooping = false; // 控制是否循环播放

        // 初始化记忆播放功能
        this.loadPlaybackState();
    }

    togglePlay() {
        if (this.audio.paused || this.audio.ended) {
            this.audio.play();
            this.updateUI(true);
            this.savePlaybackState(); // 保存播放状态
        } else {
            this.audio.pause();
            this.updateUI(false);
            this.savePlaybackState(); // 保存播放状态
        }
    }

    updateUI(isPlaying) {
        let controlPanelObj = this.controlPanel,
            infoBarObj = this.infoBar;
        
        if (isPlaying) {
            controlPanelObj.classList.add('active');
            infoBarObj.classList.add('active');
        } else {
            controlPanelObj.classList.remove('active');
            infoBarObj.classList.remove('active');
        }
    }

    handleSongEnd() {
        if (this.isLooping) {
            this.audio.currentTime = 0;
            this.audio.play();
        } else {
            this.updateUI(false); // 当歌曲结束时更新UI显示暂停状态
            this.savePlaybackState(); // 保存播放状态
        }
    }

    setLoop(isLooping) {
        this.isLooping = isLooping;
    }

    formatTime(seconds) {
        const minutes = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${minutes}:${secs < 10 ? '0' + secs : secs}`;
    }

    updateProgress() {
        const currentTime = this.audio.currentTime;
        const duration = this.audio.duration;
        const percent = (currentTime / duration) * 100;
        this.bar.style.width = `${percent}%`;
        this.currentTimeSpan.textContent = this.formatTime(currentTime);
        this.durationSpan.textContent = this.formatTime(duration);
        this.savePlaybackState(); // 保存播放状态
    }

    seek(event) {
        const rect = this.progressBar.getBoundingClientRect();
        const clickX = event.clientX - rect.left;
        const totalWidth = rect.width;
        const seekTime = (clickX / totalWidth) * this.audio.duration;
        this.audio.currentTime = seekTime;
        this.savePlaybackState(); // 保存播放状态
    }

    savePlaybackState() {
        localStorage.setItem('isPlaying', this.audio.paused ? 'false' : 'true');
        localStorage.setItem('currentTime', this.audio.currentTime);
    }

    loadPlaybackState() {
        const isPlaying = localStorage.getItem('isPlaying') === 'true';
        const currentTime = parseFloat(localStorage.getItem('currentTime'));

        if (isPlaying) {
            this.audio.currentTime = currentTime;
            this.audio.play();
            this.updateUI(true);
        } else {
            this.audio.currentTime = currentTime;
            this.updateUI(false);
        }
    }
}

// 创建音乐播放器实例并设置音频源为铃儿响叮当
const musicPlayer = new MusicPlayer('/wp-content/themes/panda/assets/others/snowy/mp3/jingle-bells.mp3');

// 如果需要开启循环播放，可以调用下面的方法
musicPlayer.setLoop(true);

// 圣诞节倒计时
console.clear();

function CountdownTracker(label, value){

  var el = document.createElement('span');

  el.className = 'flip-clock__piece';
  el.innerHTML = '<b class="flip-clock__card card"><b class="card__top"></b><b class="card__bottom"></b><b class="card__back"><b class="card__bottom"></b></b></b>' + 
    '<span class="flip-clock__slot">' + label + '</span>';

  this.el = el;

  var top = el.querySelector('.card__top'),
      bottom = el.querySelector('.card__bottom'),
      back = el.querySelector('.card__back'),
      backBottom = el.querySelector('.card__back .card__bottom');

  this.update = function(val){
    val = ( '0' + val ).slice(-2);
    if ( val !== this.currentValue ) {
      
      if ( this.currentValue >= 0 ) {
        back.setAttribute('data-value', this.currentValue);
        bottom.setAttribute('data-value', this.currentValue);
      }
      this.currentValue = val;
      top.innerText = this.currentValue;
      backBottom.setAttribute('data-value', this.currentValue);

      this.el.classList.remove('flip');
      void this.el.offsetWidth;
      this.el.classList.add('flip');
    }
  }
  
  this.update(value);
}

function getTimeRemaining(endtime) {
  var t = Date.parse(endtime) - Date.parse(new Date());
  return {
    'Total': t,
    '天': Math.floor(t / (1000 * 60 * 60 * 24)),
    '小时': Math.floor((t / (1000 * 60 * 60)) % 24),
    '分钟': Math.floor((t / 1000 / 60) % 60),
    '秒': Math.floor((t / 1000) % 60)
  };
}

function Clock(countdown,callback) {
  countdown = countdown ? new Date(Date.parse(countdown)) : false;
  callback = callback || function(){};
  
  var updateFn = getTimeRemaining;

  this.el = document.createElement('div');
  this.el.className = 'flip-clock';

  var trackers = {},
      t = updateFn(countdown),
      key, timeinterval;

  for ( key in t ){
    if ( key === 'Total' ) { continue; }
    trackers[key] = new CountdownTracker(key, t[key]);
    this.el.appendChild(trackers[key].el);
  }

  var i = 0;
  function updateClock() {
    timeinterval = requestAnimationFrame(updateClock);
    
    // throttle so it's not constantly updating the time.
    if ( i++ % 10 ) { return; }
    
    var t = updateFn(countdown);
    if ( t.Total < 0 ) {
      cancelAnimationFrame(timeinterval);
      for ( key in trackers ){
        trackers[key].update( 0 );
      }
      callback();
      return;
    }

    for ( key in trackers ){
      trackers[key].update( t[key] );
    }
  }

  setTimeout(updateClock,500);
}

//var deadline = new Date(Date.parse(new Date()) + 12 * 24 * 60 * 60 * 1000);
// var deadline = new Date(Date.parse(new Date('2024/12/25')));
// var c = new Clock(deadline, function(){ /* Do something when countdouwn is complete */ });
// var page_timer = document.getElementById('flip_timer');
// page_timer.appendChild(c.el);

/*
var clock = new Clock();
document.body.appendChild(clock.el);
*/