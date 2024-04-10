window.onload = function() {
    let table_headings = document.querySelectorAll('thead th');
    let table_rows = document.querySelectorAll('tbody tr');    
    
    // 2. Sorting | Ordering data of HTML table
    function sortTable(columnIndex, ascending) {
        let rows = Array.from(table_rows);
        rows.sort((rowA, rowB) => {
            let cellA = rowA.cells[columnIndex].innerText;
            let cellB = rowB.cells[columnIndex].innerText;
            return ascending ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
        });

        let tbody = document.querySelector('tbody');
        rows.forEach(row => tbody.appendChild(row));
    }

    table_headings.forEach((head, i) => {
        let sort_asc = true;
        head.onclick = () => {
            table_headings.forEach(head => head.classList.remove('active'));
            head.classList.add('active');

            document.querySelectorAll('tbody td').forEach(td => td.classList.remove('active'));
            table_rows.forEach(row => {
                row.querySelectorAll('td')[i].classList.add('active');
            })

            head.classList.toggle('asc', sort_asc);
            sort_asc = head.classList.contains('asc') ? false : true;

            sortTable(i, sort_asc);
        }
    })
}