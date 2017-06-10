<?php
require 'class/Schedule.class.php';
require 'function.php';

$schedule = new Schedule();

$next_match = $schedule->getNextMatch();
$next_practice = $schedule->getNextPractice();
$schedules = $schedule->getSchedules();
 ?>
<?php require '_include/header.php'; ?>
                <h1>Woldorf Classics</h1>
                <p class="menu"><img src="images/menu.png" alt=""></p>
            </header>
            <div class="content">
                <div class="top">
                    <div class="next-match">
                        <p class="label">次の試合</p>
                        <p class="match-name"><?php echo h($next_match['description']); ?></p>
                        <p class="place"><?php echo h($next_match['place']); ?></p>
                        <p class="date-time"><span class="date"><?php echo h(substr($next_match['sc_date'], 5)); ?></span><span class="time"><?php echo h(substr($next_match['start_time'], 0, 5)); ?></span>~</p>
                    </div>
                    <div class="next-plactis">
                        <p class="label">次の練習</p>
                        <p class="place"><?php echo h($next_practice['place']); ?></p>
                        <p class="date-time"><span class="date"><?php echo h(substr($next_practice['sc_date'], 5)); ?></span><span class="time"><?php echo h(substr($next_practice['start_time'], 0, 5)); ?></span>~<span class="time"><?php echo h(substr($next_practice['finish_time'], 0, 5)); ?></span></p>
                    </div>
                </div>
                <h2 id="schedule">Schedule</h2>
                <ul class="schedules">
                    <li class="schedule practise">
                        <p class="date">06/11</p>
                        <p class="time">時間：<span>09:00</span>~<span >13:00</span></p>
                        <p class="place">場所：野球場</p>
                        <p class="label">練習</p>
                    </li>
                    <li class="schedule match">
                        <p class="date">06/25</p>
                        <p class="time">時間：<span>09:00</span>~</p>
                        <p class="place">場所：野球場</p>
                        <p class="label">試合</p>
                    </li>
                </ul>
            </div>
<?php require '_include/footer.php'; ?>
