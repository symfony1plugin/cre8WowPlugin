jQuery(function($){
    $(document).ready(function(){
        $("#myTable").tablesorter({
            sortList: [[0, 0]],
            headers: {
                3: {
                    sorter: false
                }
            }
        });
    });
});
