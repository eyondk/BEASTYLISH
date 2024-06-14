$(document).ready(function() {
    function getISOWeek(d) {
        // Adjust the date to the nearest Thursday
        const date = new Date(d.getFullYear(), d.getMonth(), d.getDate());
        const dayNr = (date.getUTCDay() + 6) % 7;
        date.setUTCDate(date.getUTCDate() - dayNr + 3);

        const firstThursday = new Date(Date.UTC(date.getUTCFullYear(), 0, 4));
        const weekNr = 1 + Math.floor(((date - firstThursday) / 86400000 + 1) / 7);
        return weekNr;
    }

    function getWeekOfMonth(d) {
        const date = new Date(d.getFullYear(), d.getMonth(), d.getDate());
        const firstDayOfMonth = new Date(date.getFullYear(), date.getMonth(), 1);
        const dayOfYear = Math.ceil((date - firstDayOfMonth) / (1000 * 60 * 60 * 24));
        return Math.ceil(dayOfYear / 7);
    }

    function logOrderDetails(date) {
        const weekOfYear = getISOWeek(date);
        const month = date.toLocaleString('default', { month: 'short' });
        const weekOfMonth = getWeekOfMonth(date);
        console.log(`Order Date: ${date.toISOString()}`);
        console.log(`Month: ${month}`);
        console.log(`Week of the Year: Week ${weekOfYear}`);
        console.log(`Week of the Month: Week ${weekOfMonth}`);
    }

    function updateCharts(viewType) {
        var salesData, revenueData;
        var labels = [];
        var totalSales = [];
        var totalRevenue = [];

        if (viewType === 'weekly') {
            salesData = JSON.parse($('#chart').attr('data-chartweeksales'));
            revenueData = JSON.parse($('#chart').attr('data-chartweekrevenue'));
            labels = salesData.map(item => {
                var date = new Date(item.week);
                logOrderDetails(date);
                return `${date.toLocaleString('default', { month: 'short' })} - Week ${getWeekOfMonth(date)}`;
            });
            totalSales = salesData.map(item => item.total_sales);
            totalRevenue = revenueData.map(item => item.total_revenue);
        } else {
            salesData = JSON.parse($('#chart').attr('data-chartsales'));
            revenueData = JSON.parse($('#chart').attr('data-chartrevenue'));
            labels = salesData.map(item => {
                var date = new Date(item.month);
                logOrderDetails(date);
                return date.toLocaleString('default', { month: 'short' });
            });
            totalSales = salesData.map(item => item.total_sales);
            totalRevenue = revenueData.map(item => item.total_revenue);
        }

        // Update Sales Chart
        myChartSales.data.labels = labels;
        myChartSales.data.datasets[0].data = totalSales;
        myChartSales.update();

        // Update Revenue Chart
        myChartRevenue.data.labels = labels;
        myChartRevenue.data.datasets[0].data = totalRevenue;
        myChartRevenue.update();
    }

    // Initialize charts with default view (monthly)
    var ctxSales = $('#TotalSales').get(0).getContext('2d');
    var myChartSales = new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Sales',
                data: [],
                backgroundColor: 'rgba(85,85,85, 0.2)',
                borderColor: 'rgb(41, 155, 99)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    var ctxRevenue = $('#TotalRevenue').get(0).getContext('2d');
    var myChartRevenue = new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                label: 'Total Revenue',
                data: [],
                backgroundColor: 'rgba(85,85,85, 0.2)',
                borderColor: 'rgb(41, 155, 99)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });

    // Event listener for the dropdown to change chart data
    $('#chartViewSelector').change(function() {
        var selectedView = $(this).val();
        updateCharts(selectedView);
    });

    // Initial chart update
    updateCharts('monthly');
});
