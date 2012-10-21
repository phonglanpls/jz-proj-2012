function callFuncChangeTransTypeWallEarning(trans_type){
	$('#expenseCateContextLoader').toggle();
	$.get(BASE_URI+'user/wallet_func/callFuncShowEarningTransaction',{trans_type:trans_type},function(res){
		$('#expenseCateContextLoader').toggle();
		$('#wallAsyncDiv').html(res);
	});
}

function callFuncChangeTransTypeWallExpense(trans_type){
	$('#expenseCateContextLoader').toggle();
	$.get(BASE_URI+'user/wallet_func/callFuncShowExpenseTransaction',{trans_type:trans_type},function(res){
		$('#expenseCateContextLoader').toggle();
		$('#wallAsyncDiv').html(res);
	});
}

function callFuncShowEarning(){
	$('#earningContextLoader').toggle();
	$.get(BASE_URI+'user/wallet_func/callFuncShowEarningTransaction',{},function(res){
		$('#earningContextLoader').toggle();
		$('#wallAsyncDiv').html(res);
	});
}

function callFuncShowExpense(){
	$('#expenseContextLoader').toggle();
	$.get(BASE_URI+'user/wallet_func/callFuncShowExpenseTransaction',{},function(res){
		$('#expenseContextLoader').toggle();
		$('#wallAsyncDiv').html(res);
	});
}

function callFuncShowBalance(){
	$('#balanceContextLoader').toggle();
	$.get(BASE_URI+'user/wallet_func/callFuncShowBalance',{},function(res){
		$('#balanceContextLoader').toggle();
		$('#wallAsyncDiv').html(res);
	});
}
