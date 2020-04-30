<!DOCTYPE html>
<html>
    <head>
        <title>Add Expense-</title>
      

        <style>
            .hidden{
                display: none !important;
            }

            .expense th, .expense td{
                text-align: center;
            }
            .expense input{
                margin: auto;
                text-align: center;
            }

            #expenseTable th{
                border: 1px solid lightgray;
            }

            #expenseTable select, #expenseTable input{
                width:100%;
                height: 30px;
            }

            #expenseTable .close{
                border: 1px solid lightgray;
                background-color: #b55959;
                width: 47px;
                text-align: center;
                /* margin-left: 2px; */
                /* margin-top: 5px; */
                font-family: arial, sans-serif;
                font-size: 12px;
                cursor: pointer;
                color: #fdfcfc;
                text-decoration: none;
                padding: 5px 0px;
                display: block;
                margin: 0 auto;
            }
        </style>

        <script>
            var allHeads = [];    
            var usedHeadIds = [];    

            var head = {id:"",name:""};
            allHeads.push(head);
        </script>
    </head>

    <body>
        <form action="submit.php" method="POST">
            <table id="expenseTable" class="expense">
                <thead style="background-color: #e8e8e8; font-family: arial, sans-serif; font-size: 12px; font-weight: normal; color: darkslategray;" >
                    <tr>
                        <th style="width: 360px;">
                            Cost
                        </th>
                        <th>
                            Rate 
                        </th>
                        <th>
                            Quantity 
                        </th>
                        <th>
                            Total Price 
                        </th>
                        <th>
                            X
                        </th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
                                   

                                    <a title="Add another expense head" href="#" id="addRow" style="border: 1px solid lightgray;
    background-color: #e8e8e8;
    width: 100px;
    text-align: center;
    margin-left: 2px;
    margin-top: 5px;
    font-family: arial, sans-serif;
    font-size: 12px;
    cursor: pointer;
    color: black;
    text-decoration: none;
    padding: 5px 0px;">Add</a>
                                   
                               
                     
                    </form>
               

       
        <script src="script.js"></script>
        
    </body>
</html>