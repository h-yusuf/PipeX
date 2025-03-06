<script>
    $(document).ready(function() {
        loadRekapReport();
        loadOperatorResult();

        const rekapTable = $('#rekapTable').DataTable({
            paging: true,
            searching: true,
            responsive: true,
        });

        const operatorResultTable = $('#operatorResultTable').DataTable({
            paging: true,
            searching: true,
            responsive: true,
        });

        function loadRekapReport() {
            $.get('/api/report/rekap', function(response) {
                if (response.success) {
                    rekapTable.clear();
                    response.data.forEach(item => {
                        rekapTable.row.add([
                            item.product_name,
                            item.total_pending,
                            item.total_in_progress,
                            item.total_completed,
                            item.total_canceled
                        ]).draw(false);
                    });
                } else {
                    alert('Failed to load Work Order Recap data.');
                }
            }).fail(function() {
                alert('Error fetching Work Order Recap.');
            });
        }

        function loadOperatorResult() {
            $.get('/api/report/operator', function(response) {
                if (response.success) {
                    operatorResultTable.clear();
                    response.data.forEach(item => {
                        operatorResultTable.row.add([
                            item.operator_name,
                            item.product_name,
                            item.total_completed
                        ]).draw(false);
                    });
                } else {
                    alert('Failed to load Operator Performance Report.');
                }
            }).fail(function() {
                alert('Error fetching Operator Performance Report.');
            });
        }
    });
</script>