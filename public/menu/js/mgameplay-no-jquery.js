/* 
* Ham tao su kien touch menu
* @Author : trungcq - 08/10/2014
*/
function isTouchDevice()
{
	try{
		document.createEvent("TouchEvent");
		return true;
	}catch(e){
		return false;
	}
}

/* 
* Ham set scroll cho div
* @Author : trungcq - 08/10/2014
*/
function touchScroll()
{
	if( isTouchDevice() ){
		var el = document.getElementById('div_scroll');
		theElement.addEventListener("touchstart", touchClick, false);
	}
}

function touchClick(event) {
	event.preventDefault();
	return false;
}

/* 
* Ham mo menu trai trang chu
* @Author : trungcq - 08/10/2014
*/
function mo_menu_trai_trang_chu()
{
	menu = document.getElementById('menuRight');
	if (menu != '' && menu != undefined) {
		if(document.getElementById('mnDanhMuc')) document.getElementById("mnDanhMuc").style.display="none";
		if(document.getElementById('mnRight-closeBtn')) document.getElementById("mnRight-closeBtn").style.display="block";
	}
	show_hide_block('menuRight');
	// show_hide_block('mnRight-closeBtn');
	var v_height = window.innerHeight;
	if (document.getElementById('div_scroll')) {
		document.getElementById('div_scroll').style.height = (v_height-150) + 'px';
	}
	touchScroll();
}

/* 
* Ham dong menu trai trang chu
* @Author : trungcq - 08/10/2014
*/
function dong_menu_trai_trang_chu()
{
	show_hide_block('mnRight-closeBtn');
	show_hide_block('menuRight');
	if(document.getElementById('mnDanhMuc')) {
		document.getElementById("mnDanhMuc").style.display="block";
	}
}

/*
 * Ham ẩn/hiện 1 block
 * @param: p_object_id : ID cua object
 */
function show_hide_block(p_object_id) {
	var block = document.getElementById(p_object_id);
	if (block != '' && block != undefined) {
		if(document.getElementById(p_object_id).style.display=='none') {
			document.getElementById(p_object_id).style.display='block';
		}else{
			document.getElementById(p_object_id).style.display='none';
		}
	}
}

/*
 * Ham submit form tìm kiếm
 * @author  trungcq
 * param : string p_form : Id form
 */
function func_submit_form_tim_kiem(p_form){
	var frm = document.getElementById(p_form);
	var text_search = frm.filter_search.value;
	if(frm){
		if(text_search == null || text_search=='') {
			alert('Bạn chưa nhập game muốn tìm');
			return false;
		} else {
			var frm_search = "/";
			frm.action = frm_search;
			frm.submit();
		}
	}
}

/* 
 * Hàm submit form khi bấm enter
 * @author: trungcq
 * @param event event su kien key press
 * @* param : string p_form : Id form
 * @return boolean
 */
function func_tim_kiem_theo_tu_khoa_press(e, p_form) {
	if (typeof e == 'undefined' && window.event) { e = window.event; }
	if(e.keyCode == 13 || e.keyCode == '13'){
		func_submit_form_tim_kiem(p_form);
	}
}