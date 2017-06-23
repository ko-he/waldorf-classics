<?php
session_start();
// 定義関数の読み込み
require '../function.php';

require '../class/Joiner.class.php';
$schedule = new Schedule();

$edit_schedule = $schedule->getEditSchedule($_POST['scId']);
?>
<p><select class="" name="sc_type">
    <option value="1" <?php if($edit_schedule['sc_type'] == 1) echo 'selected'; ?>>練習</option>
    <option value="2" <?php if($edit_schedule['sc_type'] == 2) echo 'selected'; ?>>試合・大会</option>
</select></p>
<p><input type="text" name="description" value="<?php echo h($edit_schedule['description']); ?>" placeholder="大会名など"></p>
<p><input type="text" name="place" value="<?php echo h($edit_schedule['place']); ?>" placeholder="場所"></p>
<p><input type="date" name="sc_date" value="<?php echo h($edit_schedule['sc_date']); ?>"></p>
<p><input type="time" name="start_time" value="<?php echo h($edit_schedule['start_time']); ?>"></p>
<p><input type="time" name="finish_time" value="<?php echo h($edit_schedule['finish_time']); ?>"></p>
<input type="hidden" name="sc_id" value="<?php echo h($edit_schedule['id']); ?>">
<p class="submit"><input type="submit" value="submit"></p>
