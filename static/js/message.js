function loadInbox() {
	outboxPage = 1;
	$('#inboxbutton').addClass('selected');
	$('#outboxbutton').removeClass('selected');
	$.getJSON('api/notice.handler.php?act=getinbox&page=' + inboxPage, function(ret) {
		showInbox(ret);
	});
}

function showInbox(messages) {
	var row = '';
	if(messages.length == 0 && inboxPage == 1) {
		row = '<div class="empty_message">收件箱为空</div>';
	}
	for(var i = 0; i < messages.length; i++){
		var message = messages[i];
		var read = (message['read'] == '0')? false : true;
		row += '<div class="messagelist_wrap bdb" id="mid' + message['mid'] + '">';

		row += '<div class="avatar fl"><a target="_blank" href="user.php?uxh=' + message['from_uxh'] + '"><img src="' + getAvatarURL(message['from_uxh'], (message['has_avatar'] == '1')) + '" style="max-width:35px;max-height:35px;"></a></div>';
		row += '<div class="uname fl"><a target="_blank" href="user.php?uxh=' + message['from_uxh'] + '">' + message['uname'] + '</a><br />' + message['post_time'] + '</div>';
		if(read) {
			row += '<div class="title fl" onclick=""><a href="javascript:toggleMessage(' + message['mid'] + ')">' + message['title'] + '</a></div>';
		}else{
			row += '<div class="titlebold fl"><a href="javascript:expandMessage(' + message['mid'] + ')">' + message['title'] + '</a></div>';
		}
		row += '<div class="action fl"><span class="button" onclick="showPmdiv('+ message['from_uxh'] +', ' + "'" + message['uname'] + "'" +')">发消息</span><span class="button" onclick="deleteMessage(' + message['mid'] + ')">删除</span></div>';
		

		row += '<div class="clear"></div>';

		row += '<div class="content" style="display:none;">' + message['content'] + '</div>';
		row += '</div>';
	}
	
	if(messages.length == messagesPerPage) {
		$('#pager').html('<span class="button" onclick="loadMoreInbox();">加载更多</span>');
	}else{
		$('#pager').html('');
	}

	if(inboxPage == 1) {
		$('#messagelist').html(row);
	}else{
		$('#messagelist').append(row);
	}
}

function expandMessage(mid) {
	$('#mid' + mid + ' .titlebold').addClass('title');
	$('#mid' + mid + ' .title').removeClass('titlebold');
	$('#mid' + mid + ' .content').show();
	markMessageAsRead(mid);
	$('#mid' + mid + ' .title a').attr('href','javascript:void(0)');
}

function toggleMessage(mid) {
	$('#mid' + mid + ' .content').toggle();
}

function markMessageAsRead(mid) {
	unreadMessageCount--;
	refreshUnreadCount();
	$.get('api/notice.handler.php?act=markmessageasread&mid=' + mid);
	
}

function loadOutbox() {
	inboxPage = 1;
	$('#inboxbutton').removeClass('selected');
	$('#outboxbutton').addClass('selected');
	$.getJSON('api/notice.handler.php?act=getoutbox&page=' + outboxPage, function(ret) {
		showOutbox(ret);
	});
}

function showOutbox(messages) {
	var row = '';
	if(messages.length == 0 && outboxPage == 1) {
		row = '<div class="empty_message">发件箱为空</div>';
	}
	for(var i = 0; i < messages.length; i++){
		var message = messages[i];
		row += '<div class="messagelist_wrap bdb" id="mid' + message['mid'] + '">';

		row += '<div class="avatar fl"><a target="_blank" href="user.php?uxh=' + message['to_uxh'] + '"><img src="' + getAvatarURL(message['to_uxh'], (message['has_avatar'] == '1')) + '" style="max-width:35px;max-height:35px;"></a></div>';
		row += '<div class="uname fl"><a target="_blank" href="user.php?uxh=' + message['to_uxh'] + '">' + message['uname'] + '</a><br />' + message['post_time'] + '</div>';
		row += '<div class="title fl"><a href="javascript:toggleMessage(' + message['mid'] + ')">' + message['title'] + '</a></div>';		

		row += '<div class="clear"></div>';

		row += '<div class="content" style="display:none;">' + message['content'] + '</div>';
		row += '</div>';
	}

	
	if(messages.length == messagesPerPage) {
		$('#pager').html('<span class="button" onclick="loadMoreOutbox();">加载更多</span>');
	}else{
		$('#pager').html('');
	}

	if(outboxPage == 1) {
		$('#messagelist').html(row);
	}else{
		$('#messagelist').append(row);
	}
}

function loadMoreInbox() {
	inboxPage++;
	loadInbox();
}

function loadMoreOutbox() {
	outboxPage++;
	loadOutbox();
}

function deleteMessage(mid) {
	if(!confirm('确定删除消息？')) return;
	$.get('api/notice.handler.php?act=deletemessage&mid=' + mid, function(ret) {
		loadInbox();
	});
}