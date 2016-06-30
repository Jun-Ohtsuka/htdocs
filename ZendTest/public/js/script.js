//alert('javascript!');

$(function(){
  function selectChain(selectBox, chainData){
    var selectId = $(selectBox).val();
    alert(selectId);
    $.ajax({
      type: "GET",
      url: '/home/getwepon',
      dataType: "json",
      data: {
        id: selectId
      }
    })
    .done(function(response){
      alert('is done!');

      $("'div." + chainData + "'").append(respose.data);
    })
    .fail(function(jqXHR){
      alert('is fail!');
      if (jqXHR.status == 500) {
        document.head.innerHTML = "";
        document.body.innerHTML = jqXHR.responseText;
      }
    });
  };

  $('select[name="wepon1"]').change(function(){
    //alert('selectChange!');
    selectChain('select[name="wepon1"]', 'weponData1');
  });
});
