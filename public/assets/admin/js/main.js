$('#zila').change(function(){
$.get($(this).data('url'), {
        option: $(this).val()
    },
    function(data) {
        var subcat = $('#upazila');
        subcat.empty();
        subcat.append("<option value=''>-----</option>")
        $.each(data, function(index, element) {
            subcat.append("<option value='"+ element.id +"'>" + element.name + "</option>");
        });
    });
});


function exportTableToExcel(tableID, options = {}) {
    // Default options
    const {
        filename = 'export',
        excludeColumns = [],
        includeBorder = true,
        sheetName = 'Sheet1'
    } = options;

    // Get table element
    const table = document.getElementById(tableID);
    
    if (!table) {
        console.error(`Table with ID "${tableID}" not found`);
        return;
    }

    // Clone the table to avoid modifying the original
    const tableClone = table.cloneNode(true);

    // Remove excluded columns if specified
    if (excludeColumns.length > 0) {
        const rows = tableClone.querySelectorAll('tr');
        rows.forEach(row => {
            const cells = row.querySelectorAll('th, td');
            cells.forEach((cell, index) => {
                if (excludeColumns.includes(index)) {
                    cell.remove();
                }
            });
        });
    }

    // Add border styling if requested
    if (includeBorder) {
        const style = document.createElement('style');
        style.textContent = `
            table {
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid black;
                padding: 4px;
            }
            th {
                background-color: #f2f2f2;
                font-weight: bold;
            }
        `;
        tableClone.insertBefore(style, tableClone.firstChild);
    }

    // Create HTML content with proper Excel format
    let html = `
    <html xmlns:o="urn:schemas-microsoft-com:office:office" 
          xmlns:x="urn:schemas-microsoft-com:office:excel" 
          xmlns="http://www.w3.org/TR/REC-html40">
    <head>
        <!--[if gte mso 9]>
        <xml>
            <x:ExcelWorkbook>
                <x:ExcelWorksheets>
                    <x:ExcelWorksheet>
                        <x:Name>${sheetName}</x:Name>
                        <x:WorksheetOptions>
                            <x:DisplayGridlines/>
                        </x:WorksheetOptions>
                    </x:ExcelWorksheet>
                </x:ExcelWorksheets>
            </x:ExcelWorkbook>
        </xml>
        <![endif]-->
        <meta charset="UTF-8">
    </head>
    <body>
        ${tableClone.outerHTML}
    </body>
    </html>`;

    // Create blob and download link
    const blob = new Blob([html], {type: 'application/vnd.ms-excel'});
    const downloadLink = document.createElement('a');
    
    // Set download attributes
    downloadLink.href = URL.createObjectURL(blob);
    downloadLink.download = `${filename}.xls`;
    downloadLink.style.display = 'none';
    
    // Trigger download
    document.body.appendChild(downloadLink);
    downloadLink.click();
    
    // Clean up
    setTimeout(() => {
        document.body.removeChild(downloadLink);
        URL.revokeObjectURL(downloadLink.href);
    }, 100);
}

// Usage examples:
// Basic usage: exportTableToExcel('myTableId');
// With options:
// exportTableToExcel('myTableId', {
//     filename: 'monthly_report',
//     excludeColumns: [0, 2], // Excludes first and third columns (0-based index)
//     includeBorder: true,
//     sheetName: 'Monthly Data'
// });