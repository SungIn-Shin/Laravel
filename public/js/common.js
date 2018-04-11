// OTP Secret 문자열 생성
function genOtpSecretString() {
	var OTP_SECRET_VALID_TEXT = "ABCDEFGHIJKLMNOPQRSTUVWXYZ234567";
	var OTP_gen_text_length, loi;
	var OTP_gen_string = "";
	
	OTP_gen_text_length = OTP_SECRET_VALID_TEXT.length;
	
	for (var loi=1; loi<=16; loi++) {
		OTP_gen_string += OTP_SECRET_VALID_TEXT.charAt(Math.floor(Math.random() * OTP_gen_text_length));
	}
	
	document.getElementById("otpkey").value = OTP_gen_string;
	
	if (document.getElementById("chkOtpQr").checked) {
		dispOtpQr();
	}
	
	alert("새로 생성되었습니다. 하단 수정 버튼을 클릭하셔야 저장됩니다.");
}

// OPT 클립보드 복사
function copyOtpSecretString() {
	var optsec = document.getElementById("otpkey").value;
	if (window.clipboardData) {
		window.clipboardData.setData("Text", optsec);
	} else {
		prompt("Ctrl+C를 눌러 복사하세요.", optsec);
	}
}

// OTP qr 표시
function dispOtpQr() {
	var p_secret = document.getElementById("otpkey").value;
	if (document.getElementById("chkOtpQr").checked) {
		document.getElementById("qrImg").src = 'https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=200x200&chld=M|0&cht=qr&chl=otpauth://totp/ihboard%3Fsecret%3D' + p_secret;
	} else {
		document.getElementById("qrImg").src = '';
	}
}