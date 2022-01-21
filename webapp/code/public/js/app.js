function setup_popup_btn(){
  const close_popup_btn = document.getElementById("close_popup");
  var popup_container = document.getElementById('report_popup');
  close_popup_btn.addEventListener('click', function() {
    popup_container.style.visibility = "hidden";
  });
}