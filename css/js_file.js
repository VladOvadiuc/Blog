$(document).ready(function () {

	$('#sidebarCollapse').on('click', function () {
	    $('#sidebar').toggleClass('active');
	});

	});

$(function () {
  		$('[data-toggle="tooltip"]').tooltip()
	});

$(function(){		
	$("html").css("scroll-padding-top",$("#navigare").height()+$(".spacing").height());

	});

new WOW().init();


/*
	<script type="text/javascript">
		function myFunction() {
		
			const element = document.getElementById("navigare");
			const style = getComputedStyle(element);
			const desired= style.height
			const el2= document.getElementsByTagName("html")[0];
			el2.style.scrollPaddingTop=style.height ;

		}

	</script>
*/