function loadPage(page){
	$.getJSON('api/thread.handler.php?act=get&lid=' + lid + '&page=' + page, function(ret) {
		totalThreads = ret[0];
		currentPage = page;
		showForum(ret[1]);
	});
}

function showForum(threads){
	var row = '';
	if(threads.length == 0) {
		row = '<div class="empty_message">还没有人发帖，快来成为第一个发帖的吧！</div>';
	}
	for(var i = 0; i < threads.length; i++){
		var thread = threads[i];
		var top = (thread['top'] == 1);
		var lastreply_date = new strtotime(thread['lastreply_time']);
		var month = lastreply_date.getMonth() + 1;
		var timestr = '';
		var min = lastreply_date.getMinutes();
		if(min.toString().length == 1) min = '0' + min;
		if(atToday(lastreply_date)) {
			timestr = lastreply_date.getHours() + ':' + min;
		}else if(atThisYear(lastreply_date)){
			timestr =  month + '-' + lastreply_date.getDate();
		}else{
			timestr =  lastreply_date.getFullYear() + '-' +  month + '-' + lastreply_date.getDate();
		}
		row += '<div class="threadlist_wrap bdb">';
		row += '<div class="number">' + thread['view'] + '</div>';
		row += '<div class="number">' + thread['reply'] + '</div>';
		if(top) {
			row += '<div class="title"><a target="_blank" href="thread.php?tid=' + thread['tid'] + '">' + thread['subject'] + '</a>' + '<img src="static/img/topthread.gif" alt="置顶">' + '</div>';
		}else{
			row += '<div class="title"><a target="_blank" href="thread.php?tid=' + thread['tid'] + '">' + thread['subject'] + '</a></div>';
		}
		row += '<div class="author"><a target="_blank" href="user.php?uxh=' + thread['uxh'] + '">' + thread['uname'] + '</a></div>';
		row += '<div class="lastreply">' + timestr + ' ' + '<a target="_blank" href="user.php?uxh=' + thread['lastreply_uxh'] + '">' + thread['lastreply_uname'] + '</a></div>';
		if(is_admin) row += '<div class="admin"><a class="clickable" onclick="deleteThread(' + thread['tid'] + ');">删除</a></div>';	
		row += '<div class="clear"></div>';	
		row += '</div>';
	}
	$('#threadlist').html(row);
	totalPages = Math.floor((totalThreads - 1)/threadsPerPage + 1);
	var pager = '';
	var startPage = 1;
	var endPage = totalPages;
	var hasMore = false;
	if(currentPage > 5) {
		pager += '<span class="button" onclick="jumpToPage(1)">首页</span>';
		pager += '<span class="button" onclick="jumpToPage(' + (currentPage - 1) + ')">上一页</span>';
		startPage = currentPage - 4;
	}
	if((endPage - startPage) > 9) {
		hasMore = true;
		endPage = startPage + 9;
	}
	for(var i = startPage; i <= endPage; i++){
		if(i != currentPage) {
			pager += '<span class="button" onclick="jumpToPage(' + i + ')">' + i + '</span>';
		}else{
			pager += '<span class="normal" >' + i + '</span>';
		}
	}
	if(hasMore) {
		pager += '<span class="button" onclick="jumpToPage(' + (currentPage + 1) + ')">下一页</span>';
		pager += '<span class="button" onclick="jumpToPage(' + totalPages + ')">尾页</span>';
	}
	$('#pager').html(pager);
	$('#threadsnum').html('共' + totalPages + '页 共有主题数:' + (totalThreads));
}

function jumpToPage(page) {
	$.getJSON('api/thread.handler.php?act=get&lid=' + lid + '&page=' + page, function(ret) {
		totalThreads = ret[0];
		currentPage = page;
		showForum(ret[1]);
		$('#threadlist').ScrollTo();
	});
}

function refreshForum(){
	loadPage(currentPage);
}

function newThread() {
	var subject = $('#newthread_subject').val();
	var content = $('#newthread_content').val();

	if(subject.length == '') {
		alert('标题为空');
		return;
	}
	if(subject.length > 80) {
		alert('标题过长！');
		return;
	}
	if(content.length == '') {
		alert('内容为空');
		return;
	}
	if(content.length > 1024) {
		alert('内容过长！');
		return;
	}
	
	$('#submit_button').html('提交中...');
	$('#submit_button').attr('disabled', true);
	$.post("api/thread.handler.php?act=new", { s:subject, c: content, l: lid })
	.done(function(ret) {
		if(ret.lastIndexOf('0', 0) == 0) { //begin with 0
			var newtid = ret.substr(2);
			window.location.href = 'thread.php?tid=' + newtid;
		}else{
			if(ret.lastIndexOf('1', 0) == 0){
				alert(ret.substr(2));
			}
			$('#submit_button').html('提交');
			$('#submit_button').attr('disabled', false);
		}
	});
}

function deleteThread(tid) {
	if(!confirm('确定删除帖子？（ID:' + tid + '）')) return;
	$.get('api/thread.handler.php?act=delete&tid=' + tid, function(ret) {
		if(ret.lastIndexOf('0', 0) == 0) {
			refreshForum();
		}else if(ret.lastIndexOf('1', 0) == 0) {
			alert(ret.substr(2));
		}
	});
}

function showOrHideLessonmate() {
	showLessonmate = !showLessonmate;
	if(showLessonmate) {
		if(lessonmatePage == 0) {
			lessonmatePage = 1;
			loadLessonmates();
		}
		$('.lesson_content').css('width','720px');
		$('.lesson_content .title').css('width','445px');
		$('#lessonmate_block').css('display','block');
	}else{
		$('.lesson_content').css('width','874px');
		$('.lesson_content .title').css('width','590px');
		$('#lessonmate_block').css('display','none');
	}
}

function loadLessonmates(){
		$.getJSON('api/getlessonmates.php?lid=' + lid + '&page=' + lessonmatePage, function(ret) {
		showLessonmates(ret);
	});
}

function showLessonmates(lessonmates) {
	var row = '';
	for(var i = 0; i < lessonmates.length; i++){
		var lessonmate = lessonmates[i];
		var registered = (lessonmate['registered']==1);
		row += (registered) ? '<div class="lessonmatelist_wrap_registered bdl bdr bdb" title="TA也在课友网哦，点击进入TA的主页">' : '<div class="lessonmatelist_wrap bdl bdr bdb" title="该用户未在课友网注册">';
		if(registered) {
			row += '<span class="fl"><a target="_blank" href="user.php?uxh=' + lessonmate['xh'] + '"><img src="' + getAvatarURL(lessonmate['xh'], (lessonmate['has_avatar'] == 1)) + '" style="max-width:35px;max-height:35px;"></a></span>';
			row += '<span class="fl"><a target="_blank" href="user.php?uxh=' + lessonmate['xh'] + '">' + lessonmate['xm'] + '</a></span>';
		}else{
			row += '<span class="fl">' + lessonmate['xm'] + '</span>';
		}
		row += '<span title="' + lessonmate['zy'] + '专业" class="bj fr">' + lessonmate['bj'] + '</span>';
		row += '<div class="clear"></div>';	
		row += '</div>';
	}

	if(lessonmates.length == lessonmatesPerPage) {
		$('#lessonmatePager').html('<span class="button" onclick="loadMoreLessonmates();">加载更多</span>');
	}else{
		$('#lessonmatePager').html('');
	}

	if(lessonmatePage == 1) {
		$('#lessonmatelist').html(row);
	}else if(lessonmatePage > 1) {
		$('#lessonmatelist').append(row);
	}
}

function loadMoreLessonmates() {
	lessonmatePage++;
	loadLessonmates();
}