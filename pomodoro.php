<?php
/**
 * Plugin Name: Pomodoro Timer
 * Plugin URI: https://example.com/pomodoro-timer
 * Description: Adds a Pomodoro timer to the WordPress admin toolbar.
 * Version: 1.0.0
 * Author: Message Maps LLC
 * Author URI: https://messagemaps.io
 * License: GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 */




// Function to add a custom Pomodoro timer to the WordPress Toolbar in the admin area.
function my_custom_toolbar_pomodoro_timer($wp_admin_bar) {
    if (is_admin()) {
        $args = array(
            'id'     => 'my_custom_toolbar_pomodoro_timer',
            'title'  => 'Pomodoro timer - <span id="pomodoro-timer">25:00</span>
                         <button id="pomodoro-start" class="pomodoro-icon-play" title="Start"></button>
                         <button id="pomodoro-pause" class="pomodoro-icon-pause" title="Pause"></button>
                         <button id="pomodoro-reset" class="pomodoro-icon-reset" title="Reset"></button>',
            'parent' => 'top-secondary',
            'meta'   => array('class' => 'my-custom-toolbar-pomodoro-timer')
        );
        $wp_admin_bar->add_node($args);
    }
}
add_action('admin_bar_menu', 'my_custom_toolbar_pomodoro_timer', 999);

// Function to add JavaScript and CSS for the Pomodoro timer functionality.
function my_custom_toolbar_pomodoro_timer_js() {
    if (is_admin()) {
        ?>
        <script>
            let pomodoroInterval;
            let remainingSeconds = 1500;
            let isRunning = false;

            function updateTimerDisplay() {
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;
                document.getElementById('pomodoro-timer').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            }

            function startTimer() {
                clearInterval(pomodoroInterval);
                isRunning = true;
                document.getElementById('pomodoro-pause').classList.remove('pomodoro-icon-play');
                document.getElementById('pomodoro-pause').classList.add('pomodoro-icon-pause');
                document.getElementById('pomodoro-pause').title = 'Pause';
                pomodoroInterval = setInterval(() => {
                    remainingSeconds--;
                    updateTimerDisplay();
                    if (remainingSeconds <= 0) {
                        clearInterval(pomodoroInterval);
                        isRunning = false;
                    }
                }, 1000);
            }

            function togglePauseTimer() {
                if (isRunning) {
                    clearInterval(pomodoroInterval);
                    isRunning = false;
                    document.getElementById('pomodoro-pause').classList.remove('pomodoro-icon-pause');
                    document.getElementById('pomodoro-pause').classList.add('pomodoro-icon-play');
                    document.getElementById('pomodoro-pause').title = 'Resume';
                } else {
                    startTimer();
                }
            }

            function resetTimer() {
                clearInterval(pomodoroInterval);
                remainingSeconds = 1500;
                isRunning = false;
                document.getElementById('pomodoro-pause').classList.remove('pomodoro-icon-play');
                document.getElementById('pomodoro-pause').classList.add('pomodoro-icon-pause');
                document.getElementById('pomodoro-pause').title = 'Pause';
                updateTimerDisplay();
            }

            document.getElementById('pomodoro-start').addEventListener('click', startTimer);
            document.getElementById('pomodoro-pause').addEventListener('click', togglePauseTimer);
            document.getElementById('pomodoro-reset').addEventListener('click', resetTimer);
        </script>
        <style>
            .pomodoro-icon-play::before {
content: '\25B6';
}
.pomodoro-icon-pause::before {
content: '\275A\275A';
}
.pomodoro-icon-reset::before {
content: '\21BB';
}
			
#wp-admin-bar-my_custom_toolbar_pomodoro_timer,
#wp-admin-bar-my_custom_toolbar_pomodoro_timer:hover,
#wp-admin-bar-my_custom_toolbar_pomodoro_timer:focus,
#wp-admin-bar-my_custom_toolbar_pomodoro_timer * {
    color: white!important;
	background-color: #1D2327;
}
			
.my-custom-toolbar-pomodoro-timer button {
    border: none;
    width: 8px!important;
    padding: 7px 7px 0 7px!important;
    color: #aaa;
    font-size: 16px!important;
    line-height: 16px!important;
}
			
			
			
</style>
<?php
}
}
add_action('admin_footer', 'my_custom_toolbar_pomodoro_timer_js');
