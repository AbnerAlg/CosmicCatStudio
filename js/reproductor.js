const audio = document.getElementById('audio');
const playPauseButton = document.getElementById('play-pause');
const barraProgreso = document.getElementById('barra-progreso');
const tiempoActualEl = document.getElementById('tiempo-actual');
const duracionEl = document.getElementById('duracion');


audio.addEventListener('timeupdate', () => {
    const progreso = (audio.currentTime / audio.duration) * 100;
    barraProgreso.value = progreso;

    
    tiempoActualEl.textContent = formatearTiempo(audio.currentTime);
});


audio.addEventListener('loadedmetadata', () => {
    duracionEl.textContent = formatearTiempo(audio.duration);

});


barraProgreso.addEventListener('input', () => {
    const nuevaPosicion = (barraProgreso.value / 100) * audio.duration;
    audio.currentTime = nuevaPosicion;
});


playPauseButton.addEventListener('click', () => {
    if (audio.paused) {
        audio.play();
        playPauseButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-player-pause"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" /><path d="M17 4h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h2a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2z" /></svg>';
    } else {
        audio.pause();
        playPauseButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-player-play"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 4v16l13 -8z" /></svg>';
    }
});


function formatearTiempo(segundos) {
    const minutos = Math.floor(segundos / 60);
    const segundosRestantes = Math.floor(segundos % 60);
    return `${minutos}:${segundosRestantes < 10 ? '0' : ''}${segundosRestantes}`;
}