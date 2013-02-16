function checkRegisterForm() {
	var form = document.getElementById('register_form');
	var xh = form.xh.value;
	var password = form.password.value;
	var confirm_password = form.confirm_password.value;
	if(isNaN(xh) || xh.length != 9) {
		alert('请检查输入的学号是否有误');
		return;
	}
	if(password.length < 6) {
		alert('密码过短！（少于6个字符）');
		return;
	}
	if(password != confirm_password) {
		alert('两次输入的密码不一致！');
		return;
	}
	
	$('#submit_button').html('提交中...');
	$('#submit_button').attr('disabled', true);
	$.post("api/user.handler.php?act=register", { x: xh, p: password })
	.done(function(result) {
		if(result.lastIndexOf('0', 0) == 0) { //begin with 0
			$.cookie('ck', result.substr(2));
			window.location.href = 'index.php';
		}else{
			alert(result);
			$('#submit_button').html('提交');
			$('#submit_button').attr('disabled', false);
		}
	});
}