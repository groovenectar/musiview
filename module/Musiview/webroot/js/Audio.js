/*
 * License: https://github.com/groovenectar/musiview/blob/master/LICENSE.md
 * Homepage: https://c.dup.bz
*/

document.querySelectorAll('.audio-container').forEach(container => {
	const mediaElement = container.querySelector('audio')
	mediaElement.addEventListener('play', () => {
		document.querySelectorAll('.audio-container.playing').forEach(element => {
			element.querySelector('audio').pause()
		})
		container.classList.add('playing')
	})
	mediaElement.addEventListener('pause', () => container.classList.remove('playing'))
})
