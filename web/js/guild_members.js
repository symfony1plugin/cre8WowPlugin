jQuery(function($){
    $(document).ready(function(){
        $("#myTable").tablesorter({
            sortList: [[0, 0]],
            headers: {
                1: {
                    sorter: false
                },
                3: {
                    sorter: false
                },
                5: {
                    sorter: false
                },
                8: {
                    sorter: false
                }
            }
        });
    });
});
