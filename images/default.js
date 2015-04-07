// JavaScript Document
var  theDate ;
var  status_Code;
function resetForms(){
	//get form
	var theForm = document.getElementById("postForm");
	var share = document.getElementById("sharePublic");
	
	theForm.status.value = "";
	share.checked = true;
	theForm.allowLike.checked = false;
	theForm.allowComment.checked = false;
	theForm.allowShare.checked = false;
	
	theForm.statusCode.value = status_Code;
	theForm.date.value = theDate;
	
	
}
function setFormValue(code, date){
	theDate = date;
	status_Code = code;
}
	