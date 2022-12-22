$("#addTask").click(function (e) {
    e.preventDefault();
    var taskText = $("#taskTextInput").val();
    data = {
        action: "addTask"
        , taskText: taskText
    }
    tbody = document.querySelector("tbody");
    template = document.querySelector('#taskRow');
    clone = template.content.cloneNode(true);

    ajaxRequest(data).then(function (response) {
        if (response != null) {
            td = clone.querySelectorAll("td");
            td[0].textContent = response;
            td[1].textContent = taskText;
            tbody.appendChild(clone);
        }
    });
});

$("#removeAllBtn").click(function (e) {
    e.preventDefault();
    data = {
        action: 'removeAll'
    }
    ajaxRequest(data).then(function (response) {
        if (response === 'all deleted') {
            $("#taskTbl tr").remove();
        }
    });
});

$("#readyAllBtn").click(function (e) {
    e.preventDefault();
    data = {
        action: 'readyAll'
    }
    ajaxRequest(data).then(function (response) {
        if (response === 'all ready') {
            var btns = document.getElementsByClassName('task-button-done');
            for (i = 0; i < btns.length; ++i) {
                btns[i].style.cssText = 'color:green';
            }
        }
    });
});

$("#taskTbl").on("click", "#taskStatus", function (e) {
    e.preventDefault();
    var rowId = $(this).closest('tr').find('#taskId').text();

    data = {
        action: 'changeStatus',
        taskId: rowId
    }

    ajaxRequest(data).then(function (response) {
        if (response === 1) {
            document.getElementById("taskStatus").style.color = 'green';
        } else {
            document.getElementById("taskStatus").style.color = 'red';
        }
    });
});

$("#taskTbl").on("click", "#taskDelete", function (e) {
    e.preventDefault();
    var row = $(this).closest('tr');
    var rowId = row.find('#taskId').text()
    data = {
        action: 'deleteTask',
        taskId: rowId
    }

    ajaxRequest(data).then(function (response) {
        if (response != null) {
            row.remove();
        }
    });

});

function ajaxRequest(data) {
    backUrl = window.location.origin + '/backend/tasklist.php';

    return $.ajax({
        type: "POST",
        url: backUrl,
        data: data
    }).done(function (response) {
        return response;
    });

}
