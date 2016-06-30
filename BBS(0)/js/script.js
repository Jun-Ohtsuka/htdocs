$(function(){

	var dialog, addThread;
	var messages = new Array;

	//ダイアログを表示する処理
	dialog = $('#dialog').dialog({
		autoOpen: false,
		title: "新規投稿",
		minHeight: 480,
		minWidth: 500,
		modal: true,
		buttons:[{
			text: "投稿",
			click: function(){
				addThread();
			}
		},{
			text: "キャンセル",
			click: function(){
				dialog.dialog('close');
			}
		}],
		close: function(){
			$('.errorMessages > ul > li').remove();
			$('#dialog .text-box').val("");
		}
	});

	$('#newThread').click(function(){
		dialog.dialog('open');
	});

	//新規投稿に関する処理
	//-----ここから-----

	function isValidTitle(title){
		if(!title){
			messages.push("件名を入力してください");
		}else if(title.length > 50){
			messages.push("件名は50文字以下で入力してください");
		}
	};

	function isValidCategory(category){
		if(!category){
			messages.push("カテゴリーを入力してください");
		}else if(category.length > 50){
			messages.push("カテゴリーは10文字以下で入力してください");
		}
	};

	function isValidText(text){
		if(!text){
			messages.push("本文を入力してください");
		}else if(text.length > 50){
			messages.push("本文は1000文字以下で入力してください");
		}
	};


	//投稿する処理
	function addThread(){

		$('.errorMessages > ul').empty();

		var title = $('input[name="title"]').val();
		if($('.inputCategory0').css('display') == "inline"){
			var category = $('select[name="category"]').val();
		}else{
			var category = $('input[name="category"]').val();
		}
		var text = $('textarea[name="text"]').val()
		var name = $('input[name="userName"]').val();

		messages.length = 0;
		isValidTitle(title);
		isValidCategory(category);
		isValidText(text);
		var getTime = $.now();

		if(messages.length === 0){

			$.ajax({
				url: "newThread.php",
				type: 'POST',
				data:{
					title: title,
					category: category,
					text: text,
					time: getTime
				}
			}).done(function(result) {
				alert("done");
				var date = new Date(getTime).toLocaleString();
				$('#addNewThread').css('display','inline');
				$('.successMessages').text('投稿しました');

				var string = '<table class = "thread" border="1" cellspacing="0"><tr><div class = "account-name-date"><th class = "thread">Name：<span class="name">' +
				name +
				'</span>　投稿：たった今　投稿日時：' +
				date + '　<input class = "delete-button" type = "submit" name = "submit" value = "この投稿を削除する" onclick = "return confirm("本当に削除してよろしいですか？");/></th></div>'+
				'</tr><tr><td class = "title">件名：'+ title + '</td></tr>' +
				'<tr><td class = "category">カテゴリー：' + category + '</td></tr>'+
				'<tr><td class = "text"><pre class="text">'+ text + '</pre></td></tr>'+
				'<tr><td class = "comment"><form action = "delete" method = "post">'+
				'<input type = "hidden" name = "thread_id" id = "thread_id" value = "${newThreadId}" />'+
				'<input type = "hidden" name = "user_id" id = "user_id" value = "${userComment.userId }" />'+
				'<form class = "comment-area" action = "home" method = "post" >'+
				'<input type = "hidden" name = "thread_id" id = "thread_id" value = "${newThreadId}" />'+
				'＜コメントは500文字まで＞' +'<c:out value="${newThreadId}" />'+'<br>'+
				'<textarea class = "text-box" name="comment" rows = "3" cols = "50" style = "color: #999999;" onfocus="if(this.value==this.defaultValue){this.value='+"''"+';this.style.color='+'"black";}" onblur="if(this.value==""){this.value=this.defaultValue;this.style.color="#999999"}" >コメント</textarea>'+
				'<input id = "comment_submit" onclick="addComment(${loginUser.id});" type = "submit" name = "submit" value = "コメントする"/></form></td></tr></table>'

				$('#addNewThread').prepend(string);

				dialog.dialog('close');
			}).fail(function(XMLHttpRequest, textStatus, errorThrown) {
				alert("リクエスト時になんらかのエラーが発生しました：" + textStatus +":\n" + errorThrown);
			});
		}else{
			$('.errorMessages').css('display','inline');
			for(var i = 0; i < messages.length; i++){
				$('.errorMessages > ul').append('<li>'+ messages[i] + '</li>');
			}
		}
	};

	//カテゴリー入力方式を変更する処理
	$('.submit[name="categoryType"]').click(function(){
		var submit = $(this).val();
		//alert(submit);//デバッグ
		if(submit == "自由入力"){
			$('.inputCategory0').css('display', 'none');
			$('.inputCategory1').css('display', 'inline');
		}else if(submit == "一覧から選択"){
			$('.inputCategory0').css('display', 'inline');
			$('.inputCategory1').css('display', 'none');
		}
	});

	function cahgeCategoryType(){
		dialog.dialog('open');
	};

	//-----ここまで-----

	// 時間のフォーマットを書き換える
	Date.prototype.toLocaleString = function()
	{
		return [
			this.getFullYear(),
			this.getMonth() + 1,
			this.getDate()
		].join( '/' ) + ' ' + this.toLocaleTimeString();
	};

	//セレクトボックスの連動に関する処理
	//-----ここから------
	function selectChain(selectBox,chainSelectBox){
		var selectBoxVal = $(selectBox).val();
		var viewOption;

		if(selectBoxVal == 0){
			viewOption = 0;
		}else if(selectBoxVal == 1){
			viewOption = 1;
		}else{
			viewOption = 2;
		}

		var count = $(chainSelectBox).children().length;

		for(var i = 0; i < count; i++){
			var chainSelect = $(chainSelectBox + ' option:eq(' + i + ')');

			if(i == 0){
				chainSelect.show();
			}else if(viewOption == 0){
				chainSelect.show();
			}else if(viewOption == chainSelect.attr("class")){
				chainSelect.show();
			}else{
				chainSelect.hide();
			}
		}
	};

	selectChain('select[name="branch"]','select[name="position"]');


	$('select[name="branch"]').change(function(){
		selectChain('select[name="branch"]','select[name="position"]');
		$('select[name="position"]').val("0");
	});

	//-----ここまで------

});
