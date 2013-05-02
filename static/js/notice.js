function loadNotice() {
	apiGet('api/notice.handler.php?act=getnotice&page=' + noticePage, function(ret) {
		showNotice(ret);
	});
}

function showNotice(notices) {
	var row = '';
	if(notices.length == 0 && noticePage == 1) {
		row = '<div class="empty_message">暂无提醒</div>';
	}

	for(var i = 0; i < notices.length; i++){
		var notice = notices[i];
		var read = (notice['read'] == '0')? false : true;
		row += '<div class="noticelist_wrap bdb" id="nid' + notice['nid'] + '">';
		row += '<div class="avatar fl"><a target="_blank" href="user.php?uxh=' + notice['from_uxh'] + '"><img src="' + getAvatarURL(notice['from_uxh'], (notice['has_avatar'] == '1')) + '" style="max-width:35px;max-height:35px;"></a></div>';
		row += '<div class="uname fl"><a target="_blank" href="user.php?uxh=' + notice['from_uxh'] + '">' + notice['uname'] + '</a><br />' + notice['post_time'] + '</div>';
		if(notice['type'] == 'reply') {
			if(read) {
				row += '<div class="title fl" onclick=""><a target="_blank"href="thread.php?tid=' + notice['tid'] +'&pid=' + notice['pid'] + '">我回复了你的帖子“' + notice['subject'] + '”，快去看看吧</a></div>';
			}else{
				row += '<div class="titlebold fl"><a target="_blank"href="thread.php?tid=' + notice['tid'] +'&pid=' + notice['pid'] + '">我回复了你的帖子“' + notice['subject'] + '”，快去看看吧</a></div>';
			}
		}
		row += '<div class="clear"></div>';
		row += '</div>';
	}

	if(notices.length == noticesPerPage) {
		$('#pager').html('<span class="button" onclick="loadMoreNotice();">加载更多</span>');
	}else{
		$('#pager').html('');
	}
	
	if(noticePage == 1) {
		$('#noticelist').html(row);
	}else if(noticePage > 1) {
		$('#noticelist').append(row);
	}
}

function loadMoreNotice() {
	noticePage++;
	loadNotice();
}