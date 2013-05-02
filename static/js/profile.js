function setSignature() {
	var signature = $('#signature').val();
	if(signature.length > 255) {
		alert('签名过长（大于255个字符）！');
		return;
	}
	apiPost("api/user.handler.php?act=setsignature", { s: signature }, function() {
		alert('设置成功！');
	});
}

function uploadAvatar() {
	var filename = $("#avatar_file").val();
	if(!filename){return false;}
	var a = filename.split(".");
	if(a.length <=1 ){
		alert('请输入正确的文件名');
		return false;
	}
	var postfix=(a[a.length - 1]).toLowerCase();
	var valid={'jpg':1,'jpeg':1,'gif':1,'png':1};
	if(!valid[postfix]){
		alert('抱歉，目前仅支持格式为jpg、jpeg、gif、png的图片');
		return false;
	}
	
	$.ajaxFileUpload ( {
			url:'api/uploadavatar.php',
			secureuri:false,
			fileElementId:'avatar_file',
			dataType: 'json',
			success: function (ret, status) {
				if(ret.code == 1) {
					alert(ret.msg);
				}else if(ret.code == 0) {
					alert('上传成功!');
				}
			}
		}
	);
}