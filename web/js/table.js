function clearTable(table, startRow) {
  var length = table.rows.length;
  if (length > startRow) {
    for (var i = length - 1; i >= startRow; --i) {
      table.deleteRow(i);
    }
  }
}
