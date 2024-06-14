$(document).ready(function() {
    $('#downloadBtn').on('click', function() {
        var { jsPDF } = window.jspdf;

        html2canvas(document.querySelector('#salesReport')).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var pdf = new jsPDF('p', 'pt', 'a4');
            var imgProps = pdf.getImageProperties(imgData);
            var pdfWidth = pdf.internal.pageSize.getWidth();
            var pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
            pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
            pdf.save("sales_report.pdf");
        });
    });
});
