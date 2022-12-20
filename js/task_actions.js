$("#addTask").click(function (e) {
    e.preventDefault();
    var taskText = $("#taskTextInput").val();
    $.ajax({
        type: "POST",
        url: "../backend/tasklist.php",
        data: {
            action: "addTask"
            ,taskText: taskText
        }
    }).done(function (response) {
         if (response != null) {
             var appendedData = '<tr><td id="taskId" hidden>'
                 + response +
                 '<td style="width:80%">'
                 + taskText +
                 '</td><td class="noborder">' +
                 '<button class="btn" id="taskStatus" value="ready" style="color:#ff0000">READY</button>' +
                 '</td><td class="noborder"><button class="btn" value="delete">DELETE</button></td>';

             $('#taskTbl tbody').append(appendedData);

         }
    });
});

$("#removeAllBtn").click(function(e) {
    e.preventDefault();

    $.ajax({
        type: "POST",
        url: "../backend/tasklist.php",
        data: {
            action: 'removeAll'
        }
    }).done(function( response ) {
        if(response === 'all deleted'){
            $("#taskTbl tr").remove();

        }
    });
});

$("#readyAllBtn").click(function(e) {
    e.preventDefault();
    $.ajax({
        type: "POST",
        url: "../backend/tasklist.php",
        data: {
            action: 'readyAll'
        }
    }).done(function( response ) {
        if(response === 'all ready'){
            var btns = document.getElementsByClassName('task-button-done');
            for (i = 0; i < btns.length; ++i) {
                btns[i].style.cssText = 'color:green';
            }
        }
    });
});

$("#taskTbl").on("click","#taskStatus",  function(e) {
    e.preventDefault();
    var rowId = $(this).closest('tr').find('#taskId').text();
    var btnText = $(this).text();
    if(btnText ==='READY') {
        $(this).cssText = 'color:red';
    }else{
        $(this).cssText = 'color:green';
    }
    $.ajax({
        type: "POST",
        url: "../backend/tasklist.php",
        data: {
            action: 'changeStatus',
            taskId: rowId
        }
    }).done(function( response ) {
        if(response == 1){
            document.getElementById("taskStatus").style.color = 'green';
        }else{
            document.getElementById("taskStatus").style.color = 'red';
        }
    });
});



$("#taskTbl").on("click","#taskDelete",  function(e) {
    e.preventDefault();
    var row = $(this).closest('tr');
    var rowId = row.find('#taskId').text()
    $.ajax({
        type: "POST",
        url: "../backend/tasklist.php",
        data: {
            action: 'deleteTask',
            taskId: rowId
        }
    }).done(function( response ) {
        if(response != null){
            row.remove();
        }
    });
});
