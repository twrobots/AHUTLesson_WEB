function loadPage(page){
	$.getJSON('api/getforum.php?page=' + page, function(ret) {
		totalThreads = ret[0];
		currentPage = page;
		showForum(ret[1]);
	});
}

function showForum(threads){
	if(threads == null){
		alert('获取帖子列表失败...');
		return;
	}
	var row = '';
	for(var i = 0; i < threads.length; i++){
		var thread = threads[i];
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
		row += '<div class="threadlist_wrap">';
		row += '<div class="lesson"><a target="_blank" title="' +  thread['lessonname'] + '(' + thread['teachername'] + ')' + '" href="lesson.php?lid=' + thread['lid'] + '">' + thread['lessonname'] + '(' + thread['teachername'] + ')' + '</a></div>';
		row += '<div class="number">' + thread['view'] + '</div>';
		row += '<div class="number">' + thread['reply'] + '</div>';
		row += '<div class="title"><a target="_blank" href="thread.php?tid=' + thread['tid'] + '">' + thread['subject'] + '</a></div>';
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
	$.getJSON('api/getforum.php?lid=' + lid + '&page=' + page, function(ret) {
		totalThreads = ret[0];
		currentPage = page;
		showForum(ret[1]);
		$('#threadlist').ScrollTo();
	});
}

function refreshForum(){
	loadPage(currentPage);
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