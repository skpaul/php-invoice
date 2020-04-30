function expenseHeadChanged(headCombo){
    usedHeadIds.push(headCombo.value);
}

function priceChanged(textbox){
    // console.log(textbox.value);
    var rateTextbox = textbox.closest('tr').querySelector('.rate');
    var quantityTextbox = textbox.closest('tr').querySelector('.quantity');
    var totalTextbox = textbox.closest('tr').querySelector('.total');

    var rate = rateTextbox.value;
    
    var quantity = quantityTextbox.value;
    if(!isNaN(rate) && !isNaN(quantity)){
        var total = rate * quantity;
    }
    else{
        var total = 0;

    }
    totalTextbox.value = total;
}

function addOption(){
    var optionString = '<option selected="true" disabled="disabled">Choose head</option>';
    
    allHeads.forEach(function(item){
        // debugger;
        var id = item.id;
        var name = item.name;
        if(usedHeadIds.length > 0){
            var found = false;
            usedHeadIds.forEach(function(existing){
                if(existing == id){
                    found = true;
                    return;
                }
            });
            
            if(!found){
                    optionString = optionString.concat('<option value="'+ id +'">'+ name +'</option>');
            }
        }
        else{
            optionString = optionString.concat('<option value="'+ id +'">'+ name +'</option>');
        }
    });

    return optionString;
};

var btnAddRow = document.getElementById("addRow");

btnAddRow.onclick = function(){
    var expenseTable = document.getElementById('expenseTable');
    var rowCnt = expenseTable.rows.length;
    var tr = expenseTable.insertRow(rowCnt);
    var tdHead = tr.insertCell(0);
    var tdRate = tr.insertCell(1);
    var tdQuantity = tr.insertCell(2);
    var tdTotal = tr.insertCell(3);
    var tdRemove = tr.insertCell(4);
    tdHead.innerHTML ='<select name="head[]" onchange="expenseHeadChanged(this)" class="expenseHead">' + addOption() + "</select>";
    tdRate.innerHTML='<input type="text" name="rate[]" oninput="priceChanged(this)" value="0.00" class="rate"> ';
    tdQuantity.innerHTML='<input type="text" name="quantity[]" oninput="priceChanged(this)" value="0.00" class="quantity">';
    tdTotal.innerHTML = '<input type="text" name="total[]" value="0.00" class="total" readonly> ';
    tdRemove.innerHTML = '<a href="#" class="close" onclick="removeRow(this);" title="Remove this row" >X</a>';
};

function removeRow(button){
    var expenseTable = document.getElementById('expenseTable');
    var tr = button.closest('tr');
    var expenseHeadCombo = tr.querySelector('.expenseHead');
    var selectedHead = expenseHeadCombo.value;
    if(selectedHead > 0){
        for( var i = 0; i < usedHeadIds.length; i++){ 
            if ( usedHeadIds[i] === selectedHead) { 
                usedHeadIds.splice(i, 1); 
            }
        }
    }
    tr.remove();
    //expenseTable.deleteRow(index);

}
