<script type="text/javascript">
 
  $(document).on('change','.leaderboard-switch',function(e){
    window.location.href = '/?filter=on&' + $("input.leaderboard-switch").serialize();
//    $.post( "/", $("input.leaderboard-switch").serialize() + '&_token={{ csrf_token() }}' );
  })
  $(document).on('change','.item-wish',function(e){
    var datapr = 'id=' + $(this).data('for') + '&_token={{ csrf_token() }}';
    $.ajax({
				url: 'add_to_wish',
				dataType: "json",
				type: "POST",
				data: datapr,
				success: function(item){
          console.log(item);
          if ($('#wish_only').is(':checked')) {
            window.location.reload();
          }
				}
			});

  })
</script>