function loadTimetable(){
	showLoading();
	apiGet('api/getlessons.php?xh=' + xh, function(lessons, metadata) {
		xm = metadata.xm;
		showTimetable(lessons);
	});
}

function showLoading(){
	$('#loading_timetable').html('正在载入课程...');
	$('#loading_timetable').css('display','block');
	$('#timetable').css('display','none');
}

function hideLoading(){
	$('#timetable').css('display','block');
	$('#loading_timetable').css('display','none');
}

var weekNames = ["星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"];

function showTimetable(lessons){
	if(lessons == null){
		$('#loading_timetable').html('获取课表失败...');
		return;
	}
	var tablehead = '<tr>';
	for(var week = 0; week < 7; week++){
		tablehead += '<th>';
		tablehead += weekNames[week];
		tablehead += '</th>';
	}
	tablehead += '</tr>';
	var row = '<tr>';
	for(var time = 0; time < 5; time++){
		for(var week = 0; week < 7; week++){
			row += '<td>';
			if (typeof lessons[week] != 'undefined' && typeof lessons[week][time] != 'undefined') {
				var lesson = lessons[week][time];
				row += '<div title="点击进入课程讨论" class="lessongrid" onclick="openLessonForum(\'' + lesson['lid'] + '\');">';
				row += '<div class="lessonname">' + lesson['lessonname'];
				if(lesson['hasnew'] == 1) row += '<span class="hasnew">New</span>';
				row += '</div>';
				row += '<div class="teachername">' + lesson['teachername'] + '</div>';
				row += '<div class="place">' + lesson['place'] + '</div>';
				row += '</div>';
			}
			row += '</div></td>';
		}
		row += '</tr>';
	}
	$('#timetable_name').html(xm + '的课表');
	$('#timetable').html(tablehead + row);
	hideLoading();
}

function refreshTimetable(){
	xh = $('#xh').val();
	loadTimetable(xh);
}

function openLessonForum(lid) {
	window.location.href = "lesson.php?lid=" + lid;
}