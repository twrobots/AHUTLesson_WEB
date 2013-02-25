function loadThreadPage(page, topid){
	$.getJSON('api/post.handler.php?act=get&tid=' + tid + '&page=' + page, function(ret) {
		totalPosts = ret[0];
		currentPage = page;
		showThread(ret[1]);
		topid = typeof topid !== 'undefined' ? topid : false;
		if(topid != false)scrollToPost(topid);
	});
}

function showThread(posts){
	var postlist = '';
	for(var i = 0; i < posts.length; i++){
		var post = posts[i];
		postlist += '<div class="post_wrap" id="pid' + post['pid'] + '">';
		
		postlist += '<div class="post_author">';
		postlist += '<div class="post_author_icon">';
		postlist += '<a target="_blank" href="user.php?uxh=' + post['uxh'] + '"><img src="' + getAvatarURL(post['uxh'], (post['has_avatar'] == '1')) + '" ></a>';
		
		postlist += '</div>';
		postlist += '<div class="post_author_name">';
		postlist += '<a target="_blank" href="user.php?uxh=' + post['uxh'] + '">' + post['uname'] +'</a>';
		postlist += '</div>';
		
		postlist += '</div>';
		
		postlist += '<div class="post_content_main">';
		postlist += '<div class="post_content_text">' + post['content'] + '</div>';
		
		postlist += '<div class="post_content_info">';
		if(is_admin) postlist += '<span class="admin"><a class="clickable" onclick="deletePost(' + post['pid'] + ');">删除</a></span>';	
		
		if(post['from_client'] == '1') {
			postlist += '<span>来自<a target="_blank" href="android.php">Android版</a></span>';
		}
		
		postlist += '<span>' + post['floor'] + '楼</span>';
		postlist += '<span>' + post['post_time'] + '</span>';
		postlist += '</div>';
		
		postlist += '</div>';
		
		postlist += '<div class="clear">';
		postlist += '</div>';
		
		postlist += '</div>';
		
	}
	$('#postlist').html(postlist);
	totalPages = Math.floor((totalPosts - 1)/postsPerPage + 1);
	var pager = '';
	var startPage = 1;
	var endPage = totalPages;
	var hasMore = false;
	if(currentPage > 5) {
		pager += '<span class="button" onclick="jumpToThreadPage(1)">首页</span>';
		pager += '<span class="button" onclick="jumpToThreadPage(' + (currentPage - 1) + ')">上一页</span>';
		startPage = currentPage - 4;
	}
	if((endPage - startPage) > 9) {
		hasMore = true;
		endPage = startPage + 9;
	}
	for(var i = startPage; i <= endPage; i++){
		if(i != currentPage) {
			pager += '<span class="button" onclick="jumpToThreadPage(' + i + ')">' + i + '</span>';
		}else{
			pager += '<span class="normal" >' + i + '</span>';
		}
	}
	if(hasMore) {
		pager += '<span class="button" onclick="jumpToThreadPage(' + (currentPage + 1) + ')">下一页</span>';
		pager += '<span class="button" onclick="jumpToThreadPage(' + totalPages + ')">尾页</span>';
	}
	$('#pager').html(pager);
	$('#postsnum').html('共' + totalPages + '页 回复帖:' + (totalPosts - 1));
}

function jumpToThreadPage(page) {
	$.getJSON('api/post.handler.php?act=get&tid=' + tid + '&page=' + page, function(ret) {
		totalPosts = ret[0];
		currentPage = page;
		showThread(ret[1]);
		$('#postlist').ScrollTo();
	});
}

function refreshThread() {
	loadPage(currentPage);
}

function newPost() {
	var content = $('#newpost_content').val();

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
	$.post("api/post.handler.php?act=new", { c: content, t: tid })
	.done(function(ret) {
		if(ret.lastIndexOf('0', 0) == 0) {
			$('#newpost_content').val('');
			var newpid = ret.substr(2);
			window.location.href = "thread.php?tid=" + tid + "&pid=" + newpid;
		}else{
			if(ret.lastIndexOf('1', 0) == 0) {
				alert(ret.substr(2));
			}
			$('#submit_button').html('提交');
			$('#submit_button').attr('disabled', false);
		}
	});
}

function scrollToPost(pid) {
	$('#pid' + pid).ScrollTo();
}

function deletePost(pid) {
	if(!confirm('确定删除回复帖？')) return;
	$.get('api/post.handler.php?act=delete&pid=' + pid, function(ret) {
		if(ret.lastIndexOf('0', 0) == 0) {
			refreshThread();
		}else if(ret.lastIndexOf('1', 0) == 0) {
			alert(ret.substr(2));
		}
	});
}

function setThreadTop(value) {
	$.get('api/thread.handler.php?act=settop&tid=' + tid + '&value=' + value, function(ret) {
		if(ret == '') alert('done!');
	});
}