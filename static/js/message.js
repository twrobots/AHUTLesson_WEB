function loadInbox() {
	$('#inboxbutton').addClass('selected');
	$('#outboxbutton').removeClass('selected');
	$.getJSON('api/pm.handler.php?act=getinbox&page=' + inboxPage, function(ret) {
		showInbox(ret);
	});
}

function loadFirstInbox() {
	inboxPage = 1;
	loadInbox();
}

function loadFirstOutbox() {
	outboxPage = 1;
	loadOutbox();
}

function loadNextInbox() {
	inboxPage++;
	loadInbox();
}

function loadNextOutbox() {
	outboxPage++;
	loadOutbox();
}

function showInbox(messages) {
	console.log(messages);
	if(messages == null){
		alert('获取数据失败...');
		return;
	}
	var row = '';
	if(messages.length == 0) {
		row = '<div class="empty_message">收件箱为空</div>';
	}
	for(var i = 0; i < messages.length; i++){
		var message = messages[i];
		var read = (message['read'] == '0')? false : true;
		row += '<div class="messagelist_wrap bdb" id="mid' + message['mid'] + '">';

		row += '<div class="avatar fl"><a target="_blank" href="user.php?uxh=' + message['from_uxh'] + '"><img src="' + SERVER_URL + 'api/getavatar.php?uxh=' + message['from_uxh'] + '" style="max-width:35px;max-height:35px;"></a></div>';
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
	row += '<div id="pager">';
	if(messages.length == messagesPerPage) {
		row += '<span class="button" onclick="loadNextInbox();">显示更多</span>';
	}
	if(inboxPage > 1) {
		row += '<span class="button" onclick="loadFirstInbox();">返回首页</span>';
	}
	row += '</div>';
	$('#messagelist').html(row);
}

function expandMessage(mid) {
	$('#mid' + mid + ' .titlebold').addClass('title');
	$('#mid' + mid + ' .title').removeClass('titlebold');
	$('#mid' + mid + ' .content').show();
	markAsRead(mid);
	$('#mid' + mid + ' .title a').attr('href','javascript:void(0)');
}

function toggleMessage(mid) {
	$('#mid' + mid + ' .content').toggle();
}

function markAsRead(mid) {
	unreadCount--;
	refreshUnreadCount();
	$.get('api/pm.handler.php?act=markasread&mid=' + mid);
	
}

function loadOutbox() {
	$('#inboxbutton').removeClass('selected');
	$('#outboxbutton').addClass('selected');
	$('#messagelist').html('');
	$.getJSON('api/pm.handler.php?act=getoutbox&page=' + outboxPage, function(ret) {
		showOutbox(ret);
	});
}

function showOutbox(messages) {
	console.log(messages);
	if(messages == null){
		alert('获取数据失败...');
		return;
	}
	var row = '';
	if(messages.length == 0) {
		row = '<div class="empty_message">发件箱为空</div>';
	}
	for(var i = 0; i < messages.length; i++){
		var message = messages[i];
		var read = (message == '0')? false : true;
		row += '<div class="messagelist_wrap bdb" id="mid' + message['mid'] + '">';

		row += '<div class="avatar fl"><a target="_blank" href="user.php?uxh=' + message['to_uxh'] + '"><img src="' + SERVER_URL + 'api/getavatar.php?uxh=' + message['to_uxh'] + '" style="max-width:35px;max-height:35px;"></a></div>';
		row += '<div class="uname fl"><a target="_blank" href="user.php?uxh=' + message['to_uxh'] + '">' + message['uname'] + '</a><br />' + message['post_time'] + '</div>';
		row += '<div class="title fl"><a href="javascript:toggleMessage(' + message['mid'] + ')">' + message['title'] + '</a></div>';		

		row += '<div class="clear"></div>';

		row += '<div class="content" style="display:none;">' + message['content'] + '</div>';
		row += '</div>';
	}

	row += '<div>';
	if(messages.length == messagesPerPage) {
		row += '<span class="button" onclick="loadNextOutbox();">显示更多</span>';
	}
	if(outboxPage > 1) {
		row += '<span class="button" onclick="loadFirstOutbox();">返回首页</span>';
	}
	row += '</div>';
	$('#messagelist').html(row);
}

function deleteMessage(mid) {
	if(!confirm('确定删除消息？')) return;
	$.get('api/pm.handler.php?act=delete&mid=' + mid, function(ret) {
		if(ret != '0') {
			alert(ret);
		}
	});
	loadInbox();
}