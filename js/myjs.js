$(function(){
	$('ul.nav li.dropdown').hover(function(){
		$('.dropdown-menu',this).fadeIn();
	},function(){
		$('.dropdown-menu',this).fadeOut('fast');
	});
});
$(".dropdown-menu li a").click(function(){
  var selText = $(this).text();
  $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
});

$("#btnSearch").click(function(){
	alert($('.btn-select').text()+", "+$('.btn-select2').text());
});