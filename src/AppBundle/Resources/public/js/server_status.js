/**
 * To operate Server Queue Status
 * @author Jayraj Arora <jayraja@mindfiresolutions.com>
 */
$(document).ready(function () {

    //Setting the checkbox on page load
    let $field = $('#status');
    let status = parseInt($field.val());
    $field.iCheck('destroy');
    if (status === 1) {
        $field.prop('checked', true);
    }

    //Code for server queue checkbox functioning
    $field.on('change', function (e) {
        let returnVal = false;
        let statusVal = 0;
        if ($field.prop('checked')) {
            returnVal = confirm('Are you sure you want to start the server?');
            statusVal = 1;
            if (!returnVal) {
                $field.prop('checked', false);
            }
        } else {
            returnVal = confirm('Are you sure you want to stop the server?');
            if (!returnVal) {
                $field.prop('checked', true);
            }
        }

        if (returnVal) {
            let url = Routing.generate('admin_update_server_run_status', {status: statusVal});
            window.open(url, '_self');
        }
    });
});
