function loadForumPage(page){
	apiGet('api/getforum.php?page=' + page, function(data, metadata) {
		totalThreads = metadata.total;
		threadsPerPage = metadata.threadsPerPage;
		currentPage = page;
		showForum(data);
	});
}

function showForum(threads){
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
		if(is_admin) row += '<div class="admin"><a class="clickable" onclick="deleteForumThread(' + thread['tid'] + ');">删除</a></div>';	
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
		pager += '<span class="button" onclick="jumpToForumPage(1)">首页</span>';
		pager += '<span class="button" onclick="jumpToForumPage(' + (currentPage - 1) + ')">上一页</span>';
		startPage = currentPage - 4;
	}
	if((endPage - startPage) > 9) {
		hasMore = true;
		endPage = startPage + 9;
	}
	for(var i = startPage; i <= endPage; i++){
		if(i != currentPage) {
			pager += '<span class="button" onclick="jumpToForumPage(' + i + ')">' + i + '</span>';
		}else{
			pager += '<span class="normal" >' + i + '</span>';
		}
	}
	if(hasMore) {
		pager += '<span class="button" onclick="jumpToForumPage(' + (currentPage + 1) + ')">下一页</span>';
		pager += '<span class="button" onclick="jumpToForumPage(' + totalPages + ')">尾页</span>';
	}
	$('#pager').html(pager);
	$('#threadsnum').html('共' + totalPages + '页 共有主题数:' + (totalThreads));
}

function jumpToForumPage(page) {
	$.getJSON('api/getforum.php?lid=' + lid + '&page=' + page, function(ret) {
		totalThreads = metadata.total;
		threadsPerPage = metadata.threadsPerPage;
		currentPage = page;
		showForum(data);
		$('#threadlist').ScrollTo();
	});
}

function refreshForum(){
	loadForumPage(currentPage);
}

function deleteForumThread(tid) {
	if(!confirm('确定删除帖子？（ID:' + tid + '）')) return;
	apiGet('api/thread.handler.php?act=delete&tid=' + tid, function(ret) {
		refreshForum();
	});
}